SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

USE `rcarlso` ;

#use this sql file to create the table setup over again
#this will clear all the data in each table

-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User` ;

CREATE  TABLE IF NOT EXISTS `User` (
  `UserID` INT NOT NULL AUTO_INCREMENT ,
  `Username` VARCHAR(45) NOT NULL ,
  `Password` VARCHAR(45) NOT NULL ,
  `Email` VARCHAR(45) NOT NULL ,
  `FirstName` VARCHAR(45) NOT NULL ,
  `LastName` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Post` ;

CREATE  TABLE IF NOT EXISTS `Post` (
  `PostID` INT NOT NULL AUTO_INCREMENT  ,
  `UserID` INT NOT NULL ,
  `Post` VARCHAR(45) NOT NULL ,
  `TimePosted` VARCHAR(45) NOT NULL ,
  `NumOfLikes` INT NOT NULL ,
  PRIMARY KEY (`PostID`) ,
  CONSTRAINT `fk_UserID`
    FOREIGN KEY (`UserID` )
    REFERENCES `User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `UserFavorites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UserFavorites` ;

CREATE  TABLE IF NOT EXISTS `UserFavorites` (
  `UserID` INT NOT NULL ,
  `PostID` INT NOT NULL ,
  INDEX `fk_Favorites_User1_idx` (`UserID` ASC) ,
  PRIMARY KEY (`UserID`, `PostID`) ,
  INDEX `fk_Favorites_Post1_idx` (`PostID` ASC) ,
  CONSTRAINT `fk_Favorites_User1`
    FOREIGN KEY (`UserID` )
    REFERENCES `User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Favorites_Post1`
    FOREIGN KEY (`PostID` )
    REFERENCES `Post` (`PostID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Hashtag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Hashtag` ;

CREATE  TABLE IF NOT EXISTS `Hashtag` (
  `HashtagID` INT NOT NULL AUTO_INCREMENT  ,
  `Hashtag` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`HashtagID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UserFollowing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UserFollowing` ;

CREATE  TABLE IF NOT EXISTS `UserFollowing` (
  `UserID` INT NOT NULL ,
  `FollowingUserID` INT NOT NULL ,
  INDEX `fk_Follow_User1_idx` (`UserID` ASC) ,
  PRIMARY KEY (`UserID`, `FollowingUserID`) ,
  INDEX `fk_Following_User1_idx` (`FollowingUserID` ASC) ,
  CONSTRAINT `fk_Follow_User1`
    FOREIGN KEY (`UserID` )
    REFERENCES `User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Following_User1`
    FOREIGN KEY (`FollowingUserID` )
    REFERENCES `User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PostHashtags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PostHashtags` ;

CREATE  TABLE IF NOT EXISTS `PostHashtags` (
  `PostID` INT NOT NULL ,
  `HashtagID` INT NOT NULL ,
  INDEX `fk_PostHashtags_Post1_idx` (`PostID` ASC) ,
  PRIMARY KEY (`PostID`, `HashtagID`) ,
  INDEX `fk_PostHashtags_Hashtag1_idx` (`HashtagID` ASC) ,
  CONSTRAINT `fk_PostHashtags_Post1`
    FOREIGN KEY (`PostID` )
    REFERENCES `Post` (`PostID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PostHashtags_Hashtag1`
    FOREIGN KEY (`HashtagID` )
    REFERENCES `Hashtag` (`HashtagID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`HashtagFollowing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HashtagFollowing` ;

CREATE  TABLE IF NOT EXISTS `HashtagFollowing` (
  `UserID` INT NOT NULL ,
  `HashtagID` INT NOT NULL ,
  INDEX `fk_HashtagFollowing_User1_idx` (`UserID` ASC) ,
  PRIMARY KEY (`UserID`, `HashtagID`) ,
  INDEX `fk_HashtagFollowing_Hashtag1_idx` (`HashtagID` ASC) ,
  CONSTRAINT `fk_HashtagFollowing_User1`
    FOREIGN KEY (`UserID` )
    REFERENCES `User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_HashtagFollowing_Hashtag1`
    FOREIGN KEY (`HashtagID` )
    REFERENCES `Hashtag` (`HashtagID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Comment` ;

CREATE  TABLE IF NOT EXISTS `Comment` (
  `CommentID` INT NOT NULL AUTO_INCREMENT ,
  `PostID` INT NOT NULL ,
  `Comment` VARCHAR(45) NOT NULL ,
  INDEX `fk_Comment_Post1_idx` (`PostID` ASC) ,
  PRIMARY KEY (`CommentID`) ,
  CONSTRAINT `fk_Comment_Post1`
    FOREIGN KEY (`PostID` )
    REFERENCES `Post` (`PostID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
