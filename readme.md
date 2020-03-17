# Points Of Interest

## Installation

### Install required dependencies

```composer install```

### Set up database credentials

Create a ```.env``` file containing the credentials used to login to your database

```
DATABASE_HOST="localhost"
DATABASE_NAME="db_name"
DATABASE_USER="db_user"
DATABASE_PASS="db_pass"
```

### Database

#### pointsofinterest - represents individual points of interest

| Column | Type	     | Role     |
|-------  | ------- | ------- |
| id	 | INT, PRIMARY KEY | An auto-incrementing index uniquely identifying each record
|name	|VARCHAR(255)	|the name of the POI
|type	|VARCHAR(255)	|the POI type, e.g. city, historical building, restaurant, hotel, etc
|country	|VARCHAR(255) 	|the country that the POI can be found in
|region	|VARCHAR(255)	|the region that the POI can be found in, e.g. Hampshire, Normandy, Bavaria, California, etc
|description 	|TEXT	|the POI's description
|recommended	|INT	|how many recommendations has the POI received


 
#### poi_users - represents PointsOfInterest's users 

|Column |	Type |	Role |
--------|--------|-------|
|id |	INT, PRIMARY KEY |	An auto-incrementing index uniquely identifying each record
|username |	VARCHAR(255) |	the username
|password |	VARCHAR(255) |	the password
|isadmin |	TINYINT |	are they an administrator? (0=no, 1=yes)

#### poi_reviews - represents reviews of points of interest

|Column	|Type	|Role
|-------|------|-------
|id	|INT, PRIMARY KEY|	An auto-incrementing index uniquely identifying each record
|poi_id	|INT	|the ID of the point of interest that this review relates to (from the pointsofinterest table)
|review	|TEXT	|the review itself

## Future Ideas

- [ ] Don't allow users to create POI with same name, instead update. Similarly with users. 
