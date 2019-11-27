//clist.c
#include <stdlib.h>
#include <unistd.h>
#include <stdio.h>
#include <pthread.h>

/*The list will contain elements from 0 to 99*/

#define MAX 100

typedef struct cell{
    int val;
    struct cell* next;
    pthread_mutex_t mutex;
}cell;

cell sentinel = {MAX, NULL, PTHREAD_MUTEX_INITIALIZER};
cell dummy  = {-1, &sentinel, PTHREAD_MUTEX_INITIALIZER};

pthread_mutex_t mutex = PTHREAD_MUTEX_INITIALIZER;

void toggle(cell *lst, int r){
    cell *prev = lst;
    pthread_mutex_lock(&prev->mutex);
    cell *this = lst;
    pthread_mutex_lock(&this->mutex);

    cell *removed = NULL;

    pthread_mutex_lock(&mutex);

    while(this->val < r){
        pthread_mutex_unlock(&prev->mutex);
        prev = this;
        this = this->next;
        pthread_mutex_lock(&this->mutex);
    }

    if(this->val == r){
        prev->next = this->next;
        removed = this;
    }else{
        cell *new = malloc(sizeof(cell));
        new->val = r;
        new->next = this;
        pthread_mutex_init(&new->mutex, NULL);
        prev->next = new;
        new = NULL;
    }

    pthread_mutex_unlock(&prev->mutex);
    pthread_mutex_unlock(&this->mutex);
    if(removed != NULL){
        free(removed);
    }

    return;
}

typedef struct args {
    int inc;
    int id;
    cell *list;
}args;

void *bench(void *arg){
    int inc = ((args*)arg)->inc;
    int id = ((args*)arg)->id;
    cell *lstp = ((args*)arg)->list;

    for(int i = 0; i < inc; i++){
        int r = rand() % MAX;
        toggle(lstp, r);
    }
}

int main(int argc, char *argv[]){
    if(argc != 3){
        printf("usage: list <total> <threads>\n");
        exit(0);
    }

    int n = atoi(argv[2]);
    int inc = (atoi(argv[1]) / n);

    printf("%d threads doing %d operations each\n", n, inc);

    pthread_mutex_init(&mutex, NULL);

    args *thra = malloc(n*sizeof(args));
    for(int i = 0; i < n; i++){
        thra[i].inc = inc;
        thra[i].id = i;
        thra[i].list = global;
    }

    pthread_t *thrt = malloc(n * sizeof(pthread_t));
    for(int i = 0; i < n; i++){
        pthread_create(&thrt[i], NULL, bench, &thra[i]);
    }

    for(int i = 0; i < n; i++){
        pthread_join(thrt[i], NULL);
    }

    printf("done\n");
    return 0;
}