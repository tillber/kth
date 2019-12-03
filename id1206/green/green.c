//green.c
#include <stdlib.h>
#include <ucontext.h>
#include <assert.h>
#include "green.h"

#define FALSE 0
#define TRUE 1

#define STACK_SIZE 4096
#define MAX 12

static ucontext_t main_cntx = {0};
static green_t main_green = {&main_cntx, NULL, NULL, NULL, NULL, NULL, NULL, FALSE};

static green_t *running = &main_green;
static green_t* first = NULL;
static green_t* last = NULL;

static void init() __attribute__((constructor));

void init(){
    getcontext(&main_cntx);
}

/*Ready-Queue Methods*/
/*Adds the given thread to the end of the ready-queue*/
void enqueue(green_t* thread){
    if(first == NULL){
        first = last = thread;
    }else{
        last->next = thread;
        last = thread;
    }
}

/*Retrieves and removes the first thread from the ready-queue*/
green_t* dequeue(){
    if(first == NULL){
        return NULL;
    }else{
        green_t* thread = first;

        if(first == last){
            last = NULL;
        }

        first = first->next;
        thread->next = NULL;

        return thread;
    }
}

void green_thread(){
    green_t* this = running;
    void* result = (*this->fun)(this->arg);

    //place waiting (joining) thread in ready queue
    if(this->join != NULL){
        enqueue(this->join);        
    }

    //save result of execution
    this->retval = result;

    //free allocated memory structures
    free(this->context->uc_stack.ss_sp);
    free(this->context);

    //we're a zombie
    this->zombie = TRUE;

    //find the next thread to run
    green_t* next = dequeue();

    running = next;
    setcontext(next->context);
}

int green_create(green_t *new, void *(*fun)(void*), void *arg){
    ucontext_t *cntx = (ucontext_t *)malloc(sizeof(ucontext_t));
    getcontext(cntx);

    void *stack = malloc(STACK_SIZE);

    cntx->uc_stack.ss_sp = stack;
    cntx->uc_stack.ss_size = STACK_SIZE;
    makecontext(cntx, green_thread, 0);

    new->context = cntx;
    new->fun = fun;
    new->arg = arg;
    new->next = NULL;
    new->join = NULL;
    new->retval = NULL;
    new->zombie = FALSE;

    //add new to the ready queue
    enqueue(new);
    
    return 0;
}

int green_yield(){
    green_t* suspended = running;

    //add suspended to the ready queue
    enqueue(suspended);

    //select the next thread for execution
    green_t* next = dequeue();

    running = next;
    swapcontext(suspended->context, next->context);
    return 0;
}

int green_join(green_t* thread, void** res){
    if(thread->zombie){
        //collect the result
        return 0;
    }

    green_t* suspended = running;
    //add as joining thread
    thread->join = suspended;

    //select the next thread for execution
    green_t* next = dequeue();

    running = next;
    swapcontext(suspended->context, next->context);
    return 0;
}