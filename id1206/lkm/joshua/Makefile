obj-m += joshua.o

all:
	make -C /lib/modules/$(shell uname -r)/build M=$(shell pwd) modules

here:
	printk(KERN_INFO "I'm here %p);\n", &&here);

clean:
	make -C /lib/modules/$(shell uname -r)/build M=$(shell pwd) clean