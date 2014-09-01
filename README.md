multikanban
===========

A simple kanban for multiple personal projects.


# Request & Response Examples

## API Resources

### USERS

| Endpoint | Description |
| ---- | --------------- |
| [POST /users](/#post-users) | Create a user |
| [GET /users](#get-users) | Get all users |
| [GET /users/:id](#get-user) | Get a user data |
| [PUT /users/:id](#put-user) | Update user's data |
| [DELETE /users/:id](#delete-user) | Delete user |
  
### KANBANS
  
  - [POST /users/[id]/kanbans]
  - [GET /users/[id]/kanbans]
  - [GET /users/[id]/kanbans/[id]]
  - [PUT /users/[id]/kanbans/[id]]
  - [DELETE /users/[id]/kanbans/[id]]

### TASKS

  - [POST /users/[id]/kanbans/[id]/tasks]
  - [GET /users/[id]/kanbans/[id]/tasks]
  - [GET /users/[id]/tasks]
  - [PUT /users/[id]/kanbans/[id]/tasks/[id]]
  - [DELETE /users/[id]/kanbans/[id]/tasks/[id]]

* I need a call to retrieve the total number of:
 - users
 - kanbans
 - kanbans per user
 - tasks
 - tasks per user
 - completed tasks (done + archive)
 - completed tasks (done + archive) per user
 

#### GET /users

Example: http://multikanban.com/api/users.json

Response body:

    {
        "metadata": {
            "count": 123,
        },
        "results": [
            {
                "id": "1",
                "nickname": "mezod",
                "registered": "31/08/2014",
                "numberkanbans": "7",
            },
            {
                "id": "2",
                "nickname": "cowboycoder",
                "registered": "31/08/2014",
                "numberkanbans": "3",
            },
            {
                "id": "3",
                "nickname": "gravitysrainbow",
                "registered": "31/08/2014",
                "numberkanbans": "4",
            },

        ]
    }
