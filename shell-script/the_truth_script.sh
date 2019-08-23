#!/bin/bash

# change this url to the address of The Truth Intake Flow
truth_url="https://media.giphy.com/media/TNk5NDanFOmv6/giphy.gif"

# do this The Truth bit forever
while true; do
    # show a terminal with some l33t hacker squanchiness 
    echo "WELCOME TO THE TRUTH(tm)"
    echo "ARE YOU READY TO BEAR WITNESS TO THE TRUTH!"
    echo "WOULD YOU LIKE TO HAVE THE TRUTH?"
    echo "[ y/n ]"

    # Do you want to know the truth? (y/n)
    # y -> Then tell me you want to know the truth
    # n -> lock it for 3 minutes and display "Now noone can know the truth :'(

    read wanna_know
    if [[ $wanna_know == "y" ]]; then 
        echo "Oh, that is fantastic"
        else 
        echo "Now noone can know the truth :'("
        echo "This computer terminal is locked for 33 seconds"
        sleep 33s
    fi

    while true; do
        echo "Tell me \"I want to know The Truth\""
        read really_wanna_know

        if [[ $really_wanna_know == "I want to know The Truth" ]]; then
            echo "ok cool, thank you!"
            echo "Now show us your Truest Truth"
            # start chrome with a maximized window .. play with the options here on the pi
            #   the /dev/null funkiness came from here:
            #   https://www.tecmint.com/run-linux-command-process-in-background-detach-process/
            #   kill it if it causes you problems but it does immediately release the terminal
            google-chrome --start-maximized $truth_url </dev/null &>/dev/null &
            # clean up terminal
            clear
            # wait a few seconds before we start again
            sleep 9s        
            # break loop
            break
        fi
    done

    # the guestbook ends with "Now close this and don't tell anyone!!"
done
