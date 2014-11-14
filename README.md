ossecweb-stanford
=================

Stanford tools for managing/customizing OSSEC.

This deployment is hard coded in some places for a web root of /ossec.

To use the management jQuery/jTable front-end, you will need to give the user
apache is running as access to execute sudo commands.  The sudoers file is
included for reference.

The two commands referenced from the sudoers located in /usr/local/bin for
ossec-add and ossec-del are very simple wrappers around adding and removing
agents. These scripts have not been included here.

See the Screen Shot.png for how the web UI looks.
