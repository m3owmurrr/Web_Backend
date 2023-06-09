CREATE TABLE SecurityPosts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  post_name VARCHAR(50) NOT NULL,
  post_location VARCHAR(100) NOT NULL
);

CREATE TABLE Guards (
  guard_id INT AUTO_INCREMENT PRIMARY KEY,
  guard_name VARCHAR(50) NOT NULL,
  guard_rank VARCHAR(50) NOT NULL
);

CREATE TABLE DutyLog (
  duty_id INT AUTO_INCREMENT PRIMARY KEY,
  guard_id INT NOT NULL,
  post_id INT NOT NULL,
  duty_date DATE NOT NULL,
  FOREIGN KEY (guard_id) REFERENCES Guards(guard_id),
  FOREIGN KEY (post_id) REFERENCES SecurityPosts(post_id)
);

CREATE TABLE ComplaintLog (
  complaint_id INT AUTO_INCREMENT PRIMARY KEY,
  guard_id INT NOT NULL,
  post_id INT NOT NULL,
  complaint_date DATE NOT NULL,
  complaint_description VARCHAR(200) NOT NULL,
  FOREIGN KEY (guard_id) REFERENCES Guards(guard_id),
  FOREIGN KEY (post_id) REFERENCES SecurityPosts(post_id)
);