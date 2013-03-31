/** User: bulat.fattahov Date: 14.03.13 Time: 18:41 */

angular.module('rest', ['ngResource']).
    factory('User', function ($resource) {
        var User = $resource('/rest.php', {
                update: { method: 'POST' }
            }
        );

        User.prototype.update = function (cb) {
            return User.save({id: this.id},
                angular.extend({}, this), cb);
        };

        User.prototype.destroy = function (cb) {
            return User.remove({id: this.id}, cb);
        };

        User.prototype.isExpired = function (cb) {
            var re = new RegExp("(\\d{1,2})\\.(\\d{1,2})\\.(\\d{4})");
            return new Date(this.expireDate.replace(re, "$2/$1/$3")) - new Date() < 0;
        };

        return User;
    });