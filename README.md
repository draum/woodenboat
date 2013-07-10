##WoodenBoat Database
==========

A quick attempt at using Laravel 4 for something useful.

As is noted throughout the code, I have deliberately avoided using Eloquent ORM methods, although I 
use and extend the base Eloquent classes for migration and seeding functionality.  The intention was 
to write all of the SQL queries by hand and use PDO.  The result is a odd mini-ORM.

Some things in the todo list:
 - Add sorting
 - Add more advanced search functionality
 - Add more attributes, such as sail rig options
 - Make the attributes more dynamic (allow a user to create new attributes)
 - Add photo gallery
 - Finish unit tests
 - Add 'craft' and 'builder' functionality.  Just ran out of time.
 - Add a more extensible category / craft type system
 
 The idea is that there are many designers;  each boat can have one designer.
 Each user can create a 'builder' profile, and signify that they have built one of the boat designs.
 
 Here's the quick example:
 - John Welsford designed the Pathfinder
 - Many people have built Pathfinders, all with variations on the main specs
 
 Using the craft attributes table, a craft (a boat built from a boat design) would extend and
 be able to override the boat attributes table for it's parent.
 
 Eventually, I could use the search functionality to find anyone who has built a Pathfinder
 with cedar planking on steamed oak frames in the Pacific Northwest.
 
Except for the user authentication / registration pages, underneath /app all controller, model, view and library code is original.

Some jquery was snarfed for various sundry purposes.

Because a lot of things were done via re-inventing the wheel, if I continue this project I will likely rewrite
large chunks to make use of Laravel's really nice system of bundles.