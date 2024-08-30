# OU TM470 Final Year Project API (PHP) Read Me:

Please ensure you read *both* this read.me and the corresponding read.me for the frontend mobile app [here](https://github.com/darcy-stubbins/final-year-project), in order to complete the full set up. 

There is also a V1 of this repository, you can find this for earlier changes [here](https://github.com/darcy-stubbins/final-year-project-API).

## Features 

* Login/account creation portal* 
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

## Installation 

__To run the API through terminal:__

```
./init-letsencrypt.sh 
```
And once prompted continue by entering:
```
Y 
```

## Limitations and known issues 

* At this moment there is no login/sign-up system in place beyond the frontend design
* There is currently no PDF upload support for the pattern upload section and is currently out-of-use
* There is currently no support for uploading a profile picture in the Profile section and is out-of-use
* Currently no availability to upload and/or view a PDF besides the 'placeholder' PDF
* Currently the counters within each pattern will not persist any stored count data but are functional within an instance

