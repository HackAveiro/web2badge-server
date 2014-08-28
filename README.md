web2badge-server
=================

Web2Badge is the first project of Aveiro Makers. It will be presented at Mini Maker Faire Lisbon on September 19, 2014.
Web2Badge is a system that allows an LCD badge to receive messages from the Internet, through an RF-connected gateway.


Server
-------

This repository has the code of the server component of the web2badge project.

The server has the following main functions:

  * Manage the queue of messages to be sent to the devices
  * Provide a web interface for administration and publishing manual messages
  * Poll external systems (e.g. twitter) for significant messages to be sent
  * Provide a TCP server to which the gateway(s) connect to receive the messages


License
-------
MIT licensed.
