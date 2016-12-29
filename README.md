Version francaise: README_fr.md
# Hotel management system for broken items (in hotel rooms or in offices), event management and phone lines management

The name given was "support-technique" as it was a tool for the technical department at the hotel at first.

## Getting started
1. Install and start `Docker` on your machine
2. Download and unzip this project or use git to clone it
3. Open a terminal at the root of the project
4. type `docker-compose up` and enter that (it will download and spin up all dependencies and services)
5. go to 192.168.99.100 to access the app and use `admin` as  username and `helloworld` as password
5. OR TO MANAGE DATABASE go to 192.168.99.100:8181 to open phpMyAdmin and use `root` as username and `YOURPASSWORD` as password
6. change your passwords!

## Where is my Database?
Your database is contained in the containers, however the data is saved under `./database/mysql/data`

## Can I use this?
Sure! it is free and open source, feel free to modify it and give feedback at dmateusp@gmail.com.
BUT: It is only available in French at the moment, and I might or might not translate it to English in the future (feel free to translate it yourself!)

## Should I use this?
The software is provided as it is, I cannot guarantee its functioning nor its reliability.
However, it has been used (and is still used) for the last 3 years in a big hotel/conference centre, and I did not have to provide support at any moment since it is self manageable using the UI.

## Development/history
I developed this software when I was in 2nd year of college during a two month internship in a hotel. I was in charge of improving processes by developing IT tools. The code and design was left as it was, design and coding flaws come from my lack of experience at the time.

## Features
* Admin (Administrateur) users can create and manage new users of type (Utilisateur, Service technique, Coordinateur, Standard, Administrateur)
* Admin (Administrateur) users can create and manage hotel items such as TVs, phones etc, having pre-created items was implemented because of the Housekeeping staff not being able to correctly spell French words (French being their second or third language).
* User (Utilisateur) can create new support tickets (employee that wants to report a broken printer)
* Marketing (Coordinateur) can create events and book phone lines (the system manages phone line availability)
* Reception (Standard) can see phone lines' bookings (so they can plug and unplug the lines as needed)

## Technologies
This software works with Apache http server, PHP, Yii Framework (pre-2.0), phpMyAdmin and a MySQL database.

It has been Dockerized to be self contained and easy to set up.