//dlmalloc.c

#include <stdio.h>
#include <stdint.h>
#include <sys/mman.h>
#include <errno.h>

#define TRUE 1
#define FALSE 0

#define HEAD (sizeof(struct head))
#define MIN(size) (((size)>(8))?(size):(8))
#define LIMIT(size) (MIN(0) + HEAD + size)
#define MAGIC(memory) ((struct head*)memory - 1)
#define HIDE(block) (void*)((struct head*)block + 1)

#define ALIGN 8
#define ARENA (64*1024)

//uint16_t: unsigned int with 16 bits of memory ie 2 bytes (unsigned short), t stands for type

struct head{
    uint16_t bfree; //2 bytes, the status of block before
    uint16_t bsize; //2 bytes, the size of block before
    uint16_t free; //2 bytes, the status of the block
    uint16_t size; //2 bytes, the size (max 2¹⁶, 64 KiB)
    struct head *next; // 8 bytes pointer
    struct head *prev; // 8 bytes pointer
};

/*Returns a pointer to the block after*/
struct head *after(struct head *block){
    /*Current poiner, cast it to a char pointer, add the size of the block plus the size of a header*/
    return (struct head*)((char*)block + block->size + HEAD);
}

/*Returns a pointer to the block before*/
struct head *before(struct head *block){
    return (struct head*)((char*)block - block->bsize - HEAD);
}

struct head *split(struct head *block, int size){
    printf("block size: %d\n", block->size);
    printf("size: %d\n", size);
    int rsize = block->size - size - HEAD;
    block->size = rsize;
    printf("remaining size of big block: %d\n", block->size);

    struct head *splt = after(block);
    splt->bsize = block->size;
    splt->bfree = block->free;
    splt->size = size;
    splt->free = FALSE;

    struct head *aft = after(splt);
    aft->bsize = splt->size;
    
    printf("returning the small block, size: %d\n", splt->size);
    return splt;
}

struct head *arena = NULL;

struct head *new(){
    if(arena != NULL){
        printf("one arena already allocated\n");
        return NULL;
    }

    /*using mmap, but could have used sbrk*/
    struct head *new = mmap(NULL, ARENA, PROT_READ | PROT_WRITE, MAP_PRIVATE | MAP_ANONYMOUS, -1, 0);
    if(new == MAP_FAILED){
        printf("mmap failed: error %d\n", errno);
        return NULL;
    }

    /*make room for head and dummy*/
    unsigned int size = ARENA - 2*HEAD;

    new->bfree = FALSE; //changed from NULL to FALSE (bool cant be NULL)
    new->bsize = 0; //changed from NULL to 0 (int cant be NULL)
    new->free = TRUE;
    new->size = size;

    struct head *sentinel = after(new);

    /*only touch the status fields*/
    sentinel->bfree = new->free;
    sentinel->bsize = new->size;
    sentinel->free = FALSE;
    sentinel->size = 0; //changed from NULL to 0 (int cant be NULL)

    /*this is the only arena we have*/
    arena = (struct head*)new;

    return new;
}

/*Global variable for the freelist*/
struct head *flist;

/*Initialises the arena/freelist*/
void init(){
    flist = (struct head*)new();
}

/*Detaches a block from the freelist*/
void detach(struct head *block){
    if(block->next != NULL){
        block->next->prev = block->prev;
    }

    if(block->prev != NULL){
        block->prev->next = block->next;
    }
    
    if(block == flist){
        flist = flist->next;
    }
}

/*Inserts a block to the front of the freelist*/
void insert(struct head *block){
    block->next = flist;
    block->prev = NULL;

    if(flist != NULL){
        flist->prev = block;
    }

    flist = block;
}

int adjust(size_t size){
    int rem = size % ALIGN;
    if(rem == 0){
        return size;
    }else{
        return size + ALIGN - rem;
    }
}

struct head* find(int size){
    struct head *i = flist;
    if(i == NULL){
        return NULL;
    }else{
        while(i != NULL){
            if(i->size >= size){
                detach(i);
                if(i->size > LIMIT(size)){
                    struct head* taken = split(i, size);
                    insert(before(taken));
                }

                i->free = FALSE;

                if(i->next != NULL){
                    i->next->prev = i->prev;
                }
            
                return i;
            }

            i = i->next;
        }
    }
}

void *dalloc(size_t request){
    if(request <= 0){
        return NULL;
    }

    int size = adjust(request);
    printf("adjusted size\n");
    struct head *taken = find(size); //Kolla om detta är rätt
    printf("taken\n");

    if(taken == NULL){
        return NULL;
    }else{
        return HIDE(taken); //HIDE(taken)
    }
}

struct head* merge(struct head* block){
    struct head* aft = after(block);

    if(block->bfree){
        //unlink the block before
        detach(before(block));

        //calculate and set the total size of the merged blocks
        int total_size = (before(block)->size + block->size + HEAD);
        before(block) = total_size;

        //update the block after the merged blocks
        aft->prev = before(block);

        //continue with the merged block
        block = before(block);
    }

    if(aft->free){
        //unlink the block
        detach(aft);

        //calculate and set the total size of merged blocks
        int total_size = (aft->size + block->size + HEAD);
        block->size = total_size;

        //update the block after the merged blocks
        aft->next->prev = block;
    }

    return block;
}

void dfree(void *memory){
    if(memory != NULL){
        struct head *block = MAGIC(memory); 
        struct head *aft = after(block);
        block->free = TRUE;
        aft->bfree = TRUE;
        insert(block);
    }
    return;
}

/*Calculates the length of the freelist*/
int length(){
    struct head *i = flist;
    int count = 0;
    while(i != NULL){
        count++;
        i = i->next;
    }
    return count;
}

void sanity(){
    printf("sanity check:\n");

    struct head* i = flist;
    int sanity = TRUE;

    if(i == NULL){
        printf("free list is empty!\n");
    }else{
        int count = 1;
        while(i != NULL){
            if(i->free == FALSE){
                printf("block #%d is not free!\n", count);
                sanity = FALSE;
            }else{
                printf("block #%d is free.\n", count);
            }

            if(i->size < MIN(0)){
                printf("block #%d is too small! (%d)\n", count, i->size);
                sanity = FALSE;
            }else{
                printf("block #%d size is correct (%d).\n", count, i->size);
            }

            if(i->size % 8 != 0){
                printf("block #%d size is not multiple of 8!\n", count);
                sanity = FALSE;
            }else{
                printf("block #%d size is multiple of 8\n", count);
            }

            if(i->next != NULL){
                if(i->next->prev != i){
                    printf("block #%d incorrect pointer to block #%d (%p -/-> %p)\n", count+1, count, i->next->prev, i);
                    sanity = FALSE;
                }else{
                    printf("block #%d correct pointer to block #%d (%p --> %p)\n", count+1, count, i->next->prev, i);
                }
            }
            count++;
            i = i->next;
        }

        if(sanity == TRUE){
            printf("sanity result: common sense\n");
        }else{
            printf("sanity result: absurd\n");
        }
    }
}