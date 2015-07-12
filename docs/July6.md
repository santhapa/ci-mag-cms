## Work in Progress

1. Setup Gedmo on Dcotrine library
2. Added User entity and Group and Permission entity.

## User Model
1.	User can be assigned to one group but a group can have multiple users.
2. 	Permissions are stored on permission table and group has an association with permission such that group can have many permission whereas a permmission can be assigned to multiple groups.
3. 	User permission can be handled with permissions assigned to group.

