#adding a user
INSERT INTO User (UserName,Password,Email,FirstName,LastName) Values ('newUser','1234','newUser@gmail.com','Bob','Dole');

#showing all users
SELECT * FROM User;

#inserting another user
INSERT INTO User (UserName,Password,Email,FirstName,LastName) Values ('what','321','what@gmail.com','Herp','Derp');

#making newUser make a post
INSERT INTO Post (Post,TimePosted,NumOfLikes,UserID) Values ('This is the first post','13:00 10/31/13',0,(SELECT UserID FROM User WHERE UserName = 'newUser'));

#showing a user and all their posts
SELECT * FROM User JOIN Post ON User.UserID = Post.UserID;

#updating the numOfLikes of all newUser's posts to 1
UPDATE Post SET NumOfLikes = 1 WHERE UserID = (SELECT UserID FROM User WHERE UserName = 'newUser');

#creating a hashtag
INSERT INTO Hashtag (Hashtag) VALUES ('yolo');

#showing all hashtags
SELECT * FROM Hashtag;

#associating the hashtag with the post
INSERT INTO PostHashtags (HashtagID,PostID) VALUES ((SELECT HashtagID FROM Hashtag WHERE Hashtag = 'yolo'),(SELECT PostID FROM Post WHERE Post = 'This is the first post'));

#showing all entries in PostHashtags table
SELECT * FROM PostHashtags;

#showing the posts with their hashtags
SELECT * FROM Post JOIN PostHashtags ON Post.PostID = PostHashtags.PostID JOIN Hashtag ON PostHashtags.HashtagID = Hashtag.HashtagID;

#creating a new hashtag
INSERT INTO Hashtag (Hashtag) VALUES ('freebird');

#associating the hashtag with the post
INSERT INTO PostHashtags (HashtagID,PostID) VALUES ((SELECT HashtagID FROM Hashtag WHERE Hashtag = 'freebird'),(SELECT PostID FROM Post WHERE Post = 'This is the first post'));



