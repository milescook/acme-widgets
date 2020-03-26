#!/usr/bin/env sh

bin/phpstan analyse -l 7 src
if [ $? -eq 0 ]
then
    bin/phpspec run
    if [ $? -eq 0 ]
    then
        bin/behat
        if [ $? -eq 0 ]
        then
            exit 0
        fi
    fi
fi

exit 1