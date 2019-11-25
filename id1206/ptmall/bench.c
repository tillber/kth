//bench.c

#include <stdio.h>
#include <stdint.h>
#include "dlmall.h"

struct head{
    uint16_t bfree; //2 bytes, the status of block before
    uint16_t bsize; //2 bytes, the size of block before
    uint16_t free; //2 bytes, the status of the block
    uint16_t size; //2 bytes, the size (max 2¹⁶, 64 KiB)
    struct head *next; // 8 bytes pointer
    struct head *prev; // 8 bytes pointer
};

int main(){
    init();

    int i = 1;
    while(i < 16){
        int requested = i*7;
        printf("requested size of block: %d\n", requested);
        printf("adjusted size of block: %d\n", adjust(requested));
        void* allocated_memory = dalloc(requested);
        printf("successfully allocated memory\n");

        printf("freeing memory...\n");
        dfree(allocated_memory);
        printf("successfully freed memory!\n");
        printf("length of freelist: %d\n\n", length());

        i++;
    }

    return 0;
}