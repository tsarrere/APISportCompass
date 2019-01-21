DROP DATABASE IF EXISTS SportCompassTest;

CREATE DATABASE IF NOT EXISTS SportCompassTest;
USE SportCompassTest;
# -----------------------------------------------------------------------------
#       TABLE : COMMENT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS COMMENT
 (
   IDCOMMENT INTEGER NOT NULL  ,
   IDPOST INTEGER NOT NULL  ,
   COMMENTDATE DATETIME NULL  ,
   COMMENTCONTENT VARCHAR(1000) NULL  ,
   COMMENTAUTHOR VARCHAR(128) NULL  
   , PRIMARY KEY (IDCOMMENT) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE COMMENT
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_COMMENT_POST
     ON COMMENT (IDPOST ASC);

# -----------------------------------------------------------------------------
#       TABLE : POST
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS POST
 (
   IDPOST INTEGER NOT NULL  ,
   POSTDATE DATETIME NULL  ,
   POSTCONTENT VARCHAR(10000) NULL  ,
   POSTAUTHOR VARCHAR(128) NULL  
   , PRIMARY KEY (IDPOST) 
 ) 
 comment = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE COMMENT 
  ADD FOREIGN KEY FK_COMMENT_POST (IDPOST)
      REFERENCES POST (IDPOST) ;

