//pong.c
#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <assert.h>
#include <sys/un.h>
#include <sys/socket.h>

#define NAME "pingpong"
#define TURNS 10

int main(){
    int sock;
    assert((sock = socket(AF_UNIX, SOCK_STREAM, 0)) != -1);

    struct sockaddr_un name = {AF_UNIX, NAME};
    assert(connect(sock, (struct sockaddr *)&name, sizeof(name)) != -1);

    for(int i = 0; i < TURNS; i++){
        char buffer[5];
        assert(send(sock, "pong" , 4, 0) != -1);
        assert(recv(sock, buffer, 4, 0) != -1);
        buffer[4] = 0;
        printf("pong received %s\n", buffer);
    }
}