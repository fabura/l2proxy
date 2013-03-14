/**
 * Created with IntelliJ IDEA.
 * User: bulat.fattahov
 * Date: 14.03.13
 * Time: 18:41
 * To change this template use File | Settings | File Templates.
 */
// This is a module for cloud persistance in mongolab - https://mongolab.com
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

        return Project;
    });