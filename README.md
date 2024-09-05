# OU TM470 Final Year Project API (PHP) Read Me:

Please ensure you read *both* this read.me and the corresponding read.me for the Flutter mobile app [here](https://github.com/darcy-stubbins/final-year-project), in order to complete the full set up. 

There is also a V1 of this repository, you can find this for earlier changes [here](https://github.com/darcy-stubbins/final-year-project-API).

## Features 

* Login/account creation portal
* A bottom navigation bar with four different tabs to navigate around the app, including: 
    * Home page
    * Pattern upload section* 
    * Saved pattern section 
    * Profile section*  
* The home page offers a search bar with full functionality to search over all patterns by their display names
* The ability to save/unsave a pattern by clicking the corresponding button and have that immediately displayed/un-displayed in the save section. 
* The ability to like/dislike a pattern by clicking the corresponding button. 
* On the click of the comments button, be able to view comments left by other users on each pattern 
    * Also being able to leave your own comment and it be immediately displayed in the comments section on that pattern
* Being able to view the PDF associated with the chosen pattern, with full scrolling functionality*
* Having a counter available to record number of rows/stitches etc. that may be needed*

__(* See 'Limitations' section for more information on any current issues)__

## Supported Platforms 

Linux, Mac and Windows

## Dependencies  

* Docker to run the containers, read more and download [here](https://www.docker.com/products/docker-desktop/).
* Meow SQL to view and run the database creation queries, read more and download [here](https://appimage.github.io/MeowSQL/).
* Android SDK to run the Flutter Emulator (only required if running the Flutter app along with this API), read more and download [here](https://developer.android.com/studio/install?gad_source=1&gclid=Cj0KCQjw28W2BhC7ARIsAPerrcLG96yx9NzG_xwg0tyV3cFF3MwA9PRpBaV84sWI2VznmkeC0HqPjpgaAuziEALw_wcB&gclsrc=aw.ds).

## Installation 

__To run the API through terminal:__

```
./init-letsencrypt.sh 
```
And once prompted continue by entering:
```
Y 
```

__To set up the database tables, run the following query in MeowSQL:__

_Please note: you may need to close and re-open Meow SQL after running the following query before seeing any tables._

```
CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    user_name varchar(255) NOT NULL,
    user_email varchar(255) NOT NULL, 
    user_password varchar(255) NOT NULL, 
    profile_picture varchar(255), 
    token varchar(255),
    token_expiry timestamp, 
    PRIMARY KEY (`id`)
);

CREATE TABLE `patterns` (
    `id` int NOT NULL AUTO_INCREMENT,
    pattern_name varchar(50) NOT NULL,
    user_id int NOT NULL, 
    pdf_path varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `saved` (
    pattern_id int NOT NULL,
    user_id int NOT NULL,
    PRIMARY KEY (`pattern_id`, `user_id`)
);

CREATE TABLE `likes` (
    pattern_id int NOT NULL,
    user_id int NOT NULL,
    PRIMARY KEY (`pattern_id`, `user_id`)
);

CREATE TABLE `friends` (
    `id` int NOT NULL AUTO_INCREMENT, 
    friend_id int NOT NULL,
    user_id int NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `comments` (
    `id` int NOT NULL AUTO_INCREMENT, 
    pattern_id int NOT NULL,
    user_id int NOT NULL,
    comment_body text NOT NULL, 
    PRIMARY KEY (`id`)
);

```
__To populate the database tables with 'dummy' information, run the following query in MeowSQL:__

```
INSERT INTO users (user_name, user_email, user_password)
VALUES 
('John Smith','john@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Jane Smith','jane@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Darcy Stubbins','darcy@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Stevie','steve@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Bob John','bobj@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Chris C','chris@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Jean S','jeanS123@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('DeeDee','dee99@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Alex H','alex678@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
('Mandy M','amanda@mail.com','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8');


INSERT INTO patterns (pattern_name, user_id, pdf_path)
VALUES 
('Knitted Autumn Cardigan','1','pdfpathexample.pdf'),
('Knitted Dress with Bow','10','pdfpathexample.pdf'),
('Hand Sewn Tie','7','pdfpathexample.pdf'),
('Crochet Dress','8','pdfpathexample.pdf'),
('Knitted Scarf','1','pdfpathexample.pdf'),
('Patchwork Blanket','2','pdfpathexample.pdf'),
('Matching Hat and Gloves','6','pdfpathexample.pdf'),
('Knitted Dress','4','pdfpathexample.pdf'),
('Utility Fleece','5','pdfpathexample.pdf'),
('Crochet Jumper','10','pdfpathexample.pdf'); 


INSERT INTO comments (pattern_id, user_id, comment_body)
VALUES 
('1', '2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisis tincidunt lobortis. Sed leo lacus, tempor bibendum leo vel, facilisis tempus nunc. Duis viverra eget arcu sed facilisis. Maecenas fringilla metus in nisl volutpat scelerisque. Nunc nec ligula non urna suscipit pulvinar. Duis facilisis, mi quis hendrerit pharetra, justo massa varius nulla, a mollis diam elit ac risus. Suspendisse pretium sapien nisi, ut pulvinar nunc auctor eget. Aliquam et pretium sem. Cras sit amet mollis libero, sit amet luctus purus. Fusce sit amet pharetra augue. Pellentesque ullamcorper maximus lorem, nec commodo lacus fermentum at. Cras mollis augue viverra odio sagittis, eget rhoncus sem vulputate.'),
('1', '9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fringilla metus in nisl volutpat scelerisque. Nunc nec ligula non urna suscipit pulvinar. Duis facilisis, mi quis hendrerit pharetra, justo massa varius nulla, a mollis diam elit ac risus. Suspendisse pretium sapien nisi, ut pulvinar nunc auctor eget. Aliquam et pretium sem. Cras sit amet mollis libero, sit amet luctus purus. Fusce sit amet pharetra augue. Pellentesque ullamcorper maximus lorem, nec commodo lacus fermentum at. Cras mollis augue viverra odio sagittis, eget rhoncus sem vulputate.'),
('4', '3', 'Lorem ipsum dolor Maec sit amet, consectetur adipiscing elit. Nulla facilisis tincidunt lobortis. Sed leo lacus, tempor bibendum leo vel, facilisis tempus nunc. Duis viverra eget arcu sed facilisis.enas fringilla metus in nisl volutpat scelerisque. Nunc nec ligula non urna suscipit pulvinar. Duis facilisis, mi quis hendrerit pharetra, justo massa varius nulla, a mollis diam elit ac risus. '),
('10', '7', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisis tincidunt lobortis. Sed leo lacus, tempor bibendum leo vel, facilisis tempus nunc. Duis viverra eget arcu sed facilisis.');


INSERT INTO saved (pattern_id, user_id)
VALUES 
('2','1'),
('10','5'),
('6','8'),
('5','8'),
('1','1'),
('7','9'),
('7','3');


INSERT INTO likes (pattern_id, user_id)
VALUES 
('8','1'),
('9','4'),
('3','9'),
('10','5'),
('6','5'),
('6','10'),
('1','1');


INSERT INTO friends (friend_id, user_id)
VALUES 
('10','9'),
('7','9'),
('2','4'),
('10','3'),
('5','7'),
('8','6'),
('6','2');
```

## Limitations and known issues 

* There is currently no PDF upload support for the pattern upload section and is currently out-of-use, there is however viewing capabilities shown with an example PDF
* There is currently no support for uploading a profile picture in the Profile section and is out-of-use,however again, there are viewing capabilities and device file access is available.
* Currently the counters within each pattern will not persist any stored count data but are functional within an instance

