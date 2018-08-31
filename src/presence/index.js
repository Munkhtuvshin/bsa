var redis = require('redis');

function Presence() {
  this.client = redis.createClient({
      host: process.env.REDIS_HOST || '127.0.0.1',
      port: process.env.REDIS_PORT || '6379',
  });
}
module.exports = new Presence();

/**
  * Remember a present user with their connection ID
  *
  * @param {string} connectionId - The ID of the connection
  * @param {object} meta - Any metadata about the connection
**/
Presence.prototype.upsert = function(user_id, meta) {
  //console.log(user_id)
  this.client.hset(
    'presence',
    user_id,
    JSON.stringify({
      meta,
      when: Date.now()
    }),
    function(err) {
      if (err) {
        console.error('Failed to store presence in redis: ' + err);
      }
    }
  );
};

/**
  * Remove a presence. Used when someone disconnects
  *
  * @param {string} connectionId - The ID of the connection
  * @param {object} meta - Any metadata about the connection
**/
Presence.prototype.remove = function(connectionId) {
  this.client.hdel(
    'presence',
    connectionId,
    function(err) {
      if (err) {
        console.error('Failed to remove presence in redis: ' + err);
      }
    }
  );
};

Presence.prototype.get = function(user_id, callback) {
    this.client.hget("presence", user_id, function(err, presence) {
        if (err) {
          console.error('Failed to get presence from Redis: ' + err);
          return callback([]);
        }

        var details = JSON.parse(presence);
        return callback(details)
    })
}

/**
  * Returns a list of present users, minus any expired
  *
  * @param {function} returnPresent - callback to return the present users
**/
Presence.prototype.list = function(returnPresent) {
  var active = [];
  var dead = [];
  var now = Date.now();
  var self = this;

  this.client.hgetall('presence', function(err, presence) {
    if (err) {
      console.error('Failed to get presence from Redis: ' + err);
      return returnPresent([]);
    }

    for (var connection in presence) {
      var details = JSON.parse(presence[connection]);
      //details.connection = connection;

      //console.log(now - details.when)

      // if (now - details.when > 8000) {
      //   dead.push(details);
      // } else {
        active.push(details);
      //}
    }

    if (dead.length) {
      self._clean(dead);
    }

    return returnPresent(active);
  });
};

/**
  * Cleans a list of connections by removing expired ones
  *
  * @param
**/
Presence.prototype._clean = function(toDelete) {
  console.log(`Cleaning ${toDelete.length} expired presences`);
  for (var presence of toDelete) {
    this.remove(presence.connection);
  }
};