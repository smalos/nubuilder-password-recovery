# nubuilder-password-recovery

1) Create a new table "password_request" (e.g. execute the sql below in phpMyAdmin).
We need a dedicated table in our database to store the renewal token, The table also stores its expiration date, (nuBuilder) user id, email address and usage date.
In this way we also see who requested a new password, when and if it has been used.

```
CREATE TABLE `password_request` (
  `password_request_id` int(10) UNSIGNED NOT NULL,
  `pw_user_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pw_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `pw_expiration` datetime NOT NULL,
  `pw_usedate` datetime DEFAULT NULL,
  `pw_access_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `password_request`
  ADD PRIMARY KEY (`password_request_id`);

ALTER TABLE `password_request`
  MODIFY `password_request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
```

2. In the nuBuilder root  directory, create a new folder /libs/password-recovery/. Unzip the files from the attachment and place them in the  password-recovery folder you created.

3.  Edit config.php and change the values of the following variables:
- $site_name
- $login_url
- $home_url
- $from_name
- $from_email

4. Modify nuConfig.php as shown here: 
https://forums.nubuilder.com/viewtopic.php?f=19&t=10108&p=19873#p19873
This is to to add a "Forgot Password?" link below the login button.
