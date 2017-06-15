# API

rnjeesus interfaces with a simple API. It accepts GET requests and responds with JSON (or JSONP if a `?callback` is set).

The API also exposes minimal statistics for the dataset returned.

## Examples

Example URLs:

- `/api/1..10`
    - 1 number between 1 and 10
- `/api/1..5@2`
    - 2 numbers between 1 and 5
- `/api/1..100@10/dsc`
    - 10 numbers between 1 and 100 in descending order
- `/api/-20..20@50/asc`
    - 50 numbers between -20 and 20 in ascending order

## Path

All requests go through the `/api` base path.

## Params

- **lower** _(Required)_
    - The lower bound **(Integer)**
- **upper** _(Required)_
    - The upper bound **(Integer)**
- **quantity** _(Optional)_
    - The amount of numbers **(Integer)**
    - Default: 1
- **order** _(Optional)_
    - Ordering (ascending, descending, or unset) **(String) "asc" or "dsc"**
    - Default: unset (no order)

The signature for a request looks like `/<lower>..<upper>[@<quantity>][/(asc|dsc)]`.

## Response

The JSON response contains the following keys:

- **status** (Boolean): If request was successful
- **message** (String): Request feedback. If **status** is **false**, this will contain reasoning.
- **data** (Object): Contains the randomly generated values and basic statistics on the dataset.
    - **values** (Array): Contains the values. Sorted in ascending or descending order if specified in the request.
    - **statistics** (Object): Contains the minimum, maximum, mean, and median values for the dataset.
    
The following is a sample of a successful response:

```json
{
  "status": true,
  "message": "The RNG genie has blessed you.",
  "data": {
    "values": [
      83,
      14,
      60,
      1,
      48,
      30,
      69
    ],
    "statistics": {
      "minimum": 1,
      "maximum": 83,
      "mean": 43.57142857142857,
      "median": 48
    }
  }
}
```
