#!/bin/bash

for x in *.php
do
	mv $x $x.old
	cat a > $x
	cat $x.old >> $x
	rm $x.old
done
