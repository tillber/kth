//conv.c
#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <assert.h>
#include <sys/un.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <ctype.h>

#define TEST "This is a TeST to SEE if iT wORks"
#define CLIENT "help"
#define SERVER "lower"
#define MAX 512

int main(void){
    int sock;
    char buffer[MAX];

    /*A socket is created*/
    assert((sock = socket(AF_UNIX, SOCK_DGRAM, 0)) != -1);

    struct sockaddr_un name = {AF_UNIX, CLIENT};
    assert(bind(sock, (struct sockaddr *)&name, sizeof(struct sockaddr_un)) != -1);
    
    struct sockaddr_un server = {AF_UNIX, SERVER};
    int size = sizeof(struct sockaddr_un);

    int n = sizeof(TEST);

    assert(sendto(sock, TEST, n, 0, (struct sockaddr *)&server, size) != -1);
    n = recvfrom(sock, buffer, MAX-1, 0, (struct sockaddr *)&server, &size);
    if(n == -1){
        perror("server");
    }

    buffer[n] = 0;
    printf("Client received: %s\n", buffer);
    unlink(CLIENT);
    exit(0);
}