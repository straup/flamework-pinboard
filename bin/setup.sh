#!/bin/sh

if test $OSTYPE = "FreeBSD"
then
    WHOAMI=`realpath $0`
elif [[ $OSTYPE == darwin* ]]
then
    WHOAMI=`python -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`
else
    WHOAMI=`readlink -f $0`    
fi

WHEREAMI=`dirname $WHOAMI`
PINBOARD=`dirname $WHEREAMI`

PROJECT=$1

echo "copying library files"
echo "------------------------------";

cp ${PINBOARD}/www/include/*.php	${PROJECT}/www/include/

echo "all done"
echo "------------------------------";
echo ""