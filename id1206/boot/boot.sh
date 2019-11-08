nasm -f bin -o boot.bin boot.asm
ls -l boot.bin
qemu-system-x86_64 -drive file=boot.bin,index=0,media=disk,format=raw
