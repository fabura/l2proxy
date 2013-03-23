/** User: bulat.fattahov Date: 14.03.13 Time: 18:41 */

angular.module('rest', ['ngResource']).
    factory('Project', function ($resource) {
        var Project = $resource('/rest.php', {
                update: { method: 'PUT' }
            }
        );

        Project.prototype.update = function (cb) {
            return Project.update({id: this._id.$oid},
                angular.extend({}, this, {_id: undefined}), cb);
        };

        Project.prototype.destroy = function (cb) {
            return Project.remove({id: this._id.$oid}, cb);
        };

        Project.prototype.isExpired = function (cb) {
            var re = new RegExp("(\\d{1,2})\\.(\\d{1,2})\\.(\\d{4})");
            var dateString = this.expireDate.replace(re, "$2/$1/$3");
            console.log(dateString);
            var date2 = new Date(dateString);
            console.log(date2);
            return date2 - new Date() < 0;
        };

        return Project;
    });