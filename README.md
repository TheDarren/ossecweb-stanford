ossecweb-stanford
=================

Stanford tools for managing/customizing OSSEC.

This deployment is hard coded in some places for a web root of /ossec.

To use the management jQuery/jTable front-end, you will need to give the user
apache is running as access to execute sudo commands.  The sudoers file is
included for reference.

The two commands referenced from the sudoers (ossec-add and ossec-del) are
located in ./bin for reference, but should be soft linked into /usr/local/bin.

The Screen Shot.png is an overview of the UI.

Inactive agents are highlighted in red, and you can sort the table on name, IP,
or active status in the table.  Pagination is also available for those having
many agents.
