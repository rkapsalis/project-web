![Patras Gazer](https://github.com/rkapsalis/project-web/blob/master/images/Patras_Gazer_logo.png) 

University project for the course "Web Programming and Systems".
The aim of this project is to develop a complete system of collection, management and
a crowdsourced information analysis of spatiotemporal information data on human activity.
## Introduction
Google Maps service is used by millions of mobile phones users, to provide navigation services
and spatial information searching. In order to make this happen, you need to enable
location finding functions (via GPS, Wi-Fi or 3/4G network). With this service, Google
periodically stores the user's current location in the cloud so that the users can
see the history of their movements and suggest points of interest close to
to their locations.
Items that Google maintains for users are accessible only by themselves. 
Users can download data about themselves, by going to the website
https://takeout.google.com and by selecting the data associated with the Location History service. The
data can be downloaded in JSON or KMZ format (zipped KML).
## Admin
1. **Dashboard**  
  Distribution of the number of records:  
  a. per activity type  
  b. per user   
  c. per month  
  d. per day  
  e. per hour  
  f. per year  
  
2. **Heatmap**  

3. **Delete Data from DB**

4. **Export Data**  
	After having selected some query criteria to display on a map, the
	administrator can export the associated data returned, in CSV, XML, or JSON format, to download it to a local computer.

## User
1. **Sign up**  
      The user signs up by choosing a username, a password, firstname & lastname and an email. Password must
      be at least 8 characters long and contain at least one uppercase letter, a number
      and a symbol (for example #$*&@). System creates a unique identifier (user id)
      for each user using 2-way encryption, using email and password (as key).
      
2. **User data**   
	After sign in, user can see:  
	a. eco-score (percentage of sites with body activity relative to all activities) for current month  
	b. the period covered by user uploads  
	c. the date of the latest upload  
	d. a chart showing users' eco-score for the last 12 months  
	e. an eco-score leaderboard showing the 3 users with the highest eco-score for the current month and the position of the user  

3. **User data analysis**  
   The user selects a year and a month, or a range of these values or all the months and years. Then, after the selection, user will be able to see detailed stats of   his data for the selected period. This data includes:  						
	* a graph showing the percentage of records per activity type  
	* a table showing the time of the day with the most records per activity type and a graph showing the number of records per activity type  
	* a table showing the day with the most records per activity type and a graph showing the number of records per activity type  
	* a heatmap showing users' locations for the selected period  

4. **File upload**

