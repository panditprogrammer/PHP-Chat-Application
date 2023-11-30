#############################################--- SETUP PROJECT ---###################################################
 
 ## Please follow these few steps to run the application

 1. Extract .zip file
 2. Go to Project root directory
 3. Rename ".env.example" file to ".env" 
 4. Create a Database in MySQL (phpmyadmin)
 5. Setup Project Name and Database and mail server in ".env" file (Just put the details of your google smtp app passkey generated from your google account)
 6. Download composer if you haven't install   
 7. Open Terminal in root directory and run these commands
  
 Run `composer dump-autoload` (not required)
 Run `composer install` or `php composer.phar install` 
 Run `php artisan key:generate`
 Run `php artisan storage:link`
 Run `php artisan migrate`
 Run `php artisan serve`

 8. Now project is running at http://localhost:8000

## Access application
1. Register and Login with email and password (email must be verified)
   

#################################  NEXT STEP ################################# 

# Welcome to PHMedia
A FREE Online platform for connecting people together and create group and share events, create poll, Notes and More.

Here the quick Instruction for PHMedia, which shows you how to use this Web Application.

## signup for PHMedia

- Visit http://localhost:8000/register
- Fill the valid credential and (Email will be use for login credential)  
- Verify your email with the link send by PHMedia (click on resend email verification if you haven't find any verification link)
- Once your email get verified You can login (Now, you are logged In).

## Login with existing credentials

- Visit http://localhost:8000/login
- Use Email and Password for login (Verify email if haven't)
-  Logged In : when you click on `login` you will be redirected to  respective page.

# Create a Group in PHMedia
In PHMedia Creating a Group is very Easy.
- Click on You in Left Menu of Explore section
- Click on Groups tab
- Click on `+` icon located in right side (to open a group creation modal)
- Fill the all Group details 
  - Group name : anything
  - Icon : small png, jpeg or jpeg file
  - Cover : rectangular png, jpeg or jpeg file
  - Write short description for your group
 
- click on `Create Group` Button
- this will create a group for you and show you Notification at the top right corner of main window (for 5 sec or more)
- Close opened dialong box and click on Group name or Icon to visit your brand new created group

## Update group Information 
- Currently You cannot update your group (Update will be available soon)

## Delete a Group
- Only Onwer of the group is able to delete the group and modify the group setting.
- for delete a group: Go to `You` > `Groups` Your profile and (navigate where you created your group)

## Post in Group
### Post Photo/Image (png,jpeg,jpg) in group 
- click on Photo (It will ask image files to Post) . Upload one or multiples images to share in a group
- Describe your post and 
- click on Post publish Button located in right top of `Create Post` section

### Post Video (max 15MB in size) in group (SAME AS Photos share)
- click on Video (It will ask video files to Post) . Upload one video to share in a group
- Describe your post and 
- click on Post publish Button located in right top of `Create Post` section
- Any one can like  comment and share of  group posts
- NOTE: You can create post without photo or video in the group

# Create Event in group
- click on Event tab `next` to Post Tab
- click on  `+` button (It will  open a dialong to fill the all details of event)
  - title: anything
  - Description: (Optional)
  - Valid Date (start)
  - Valid Date (end)
  - Public or Private event (Toggle by checkbox )
  - click on `create Event` It will create an event
  - Open calendar by clicking on event listed (It will show you the calendar with event )
  - Click on Month tab at the right top corner of calendar if you don't see any date
 
    
# create an event by Calendar 
- Drag one or More dates block's and it will ask you to enter event name
- Enter event name and click   `OK` (You can find all the event related to this active group)
- Open all event on  Calendar by click on `Calendar Icon` middle of the Calendar section
- If your group has no event then you can't create event by calendar  (One event created by group is required)


# Create Note  in Group (As simgle as we use note in daily life)
- go to note tab
- click on `+` icon and
- fill the all title and description
- and Finally click on `Save Note`
- Now  you have created your private Note in a group

# Create Poll in a Group
- Go to  `Polls` tab of Group
- click on `+` icon (it will open modal )
- Your Thoughts : anything
- Option: at least two option is requred
- You can add more options by click on `+` icon right of Options 
- You can remove extra Option by clicking `-` button respective option
- Finally click on `Create` button (It will  successfully create poll in the group)

# Group members
- You can see the group member by clicking on `Members` tab in the group

# Group About
- All about group in the `About`  tab in the group

# Birthday Reminder in Group
- All group member will be notify when any group member's birthday is comming.
- All Upcomming birthday members will be listed in     `Member` tab of the group

------------------ That all about group tabs ---------------------
