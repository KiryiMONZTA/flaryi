# Kiryi's FLARYI Endpoint Documentation

This document describes the possible actions performable on the `Discussion` Endpoint.

## get
```php
get(int $discussionId, array $includedFields): object
```
Get a Discussion by its ID.
### Parameters
**discussionId**  
ID of the requested Discussion.  

**includedFields**
Array with the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

### Return Values
Returns a data object containing the requested Discussion object.

## getAll


## create

