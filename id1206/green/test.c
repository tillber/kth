//test.c
#include <stdio.h>
#include <time.h>
#include "green.h"

int flag = 0;
green_cond_t cond;
green_mutex_t mutex;

/*void* test(void* arg){
    int i = *(int*)arg;
    int loop = 10000;
    while(loop > 0){
        printf("thread %d: %d\n", i, loop);
        loop--;
    }
}*/

/*void* test(void* arg){
    int id = *(int*)arg;
    int loop = 20000;
    while(loop > 0){
        green_mutex_lock(&mutex);
        while(flag != id){
            green_mutex_unlock(&mutex);
            green_cond_wait2(&cond, &mutex);
        }
        flag = (id+1)%2;
        green_cond_signal(&cond);
        green_mutex_unlock(&mutex);
        loop--;
    }
}*/

void* test(void* arg){
    int id = *(int*)arg;
    clock_t begin = clock();
    int loop = 0;
    while(loop <= 20000){
        clock_t current = clock();
        if(flag == id){
            green_mutex_lock(&mutex);
            double time_spent = ((double)(current - begin) / CLOCKS_PER_SEC) * 1000;
            printf("%d\t%d\t%.3f\n", id, loop, time_spent);
            loop++;
            flag = (id + 1)%2;
            green_mutex_unlock(&mutex);
            green_cond_signal(&cond);
        }else{
            green_cond_wait(&cond);
        }
    }
}

int main(){
    green_t g0, g1;
    int a0 = 0;
    int a1 = 1;

    green_create(&g0, test, &a0);
    green_create(&g1, test, &a1);

    green_join(&g0, NULL);
    green_join(&g1, NULL);
    return 0;
}