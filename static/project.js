/** User: bulat.fattahov Date: 14.03.13 */

angular.module('project', ['rest']).
    config(function ($routeProvider) {
        $routeProvider.
            when('/', {controller: ListCtrl, templateUrl: 'list.html'}).
            when('/edit/:projectId', {controller: EditCtrl, templateUrl: 'detail.html'}).
            when('/new', {controller: CreateCtrl, templateUrl: 'detail.html'}).
            otherwise({redirectTo: '/'});
    });


function ListCtrl($scope, Project) {
    $scope.projects = Project.query();
}


function CreateCtrl($scope, $location, Project) {
    $scope.save = function () {
        Project.save($scope.project + {"action": "new"}, function () {
            $location.path('/edit/' + $scope.project.name);
        });
    }
}


function EditCtrl($scope, $location, $routeParams, Project) {
    var self = this;

    Project.get({name: $routeParams.projectId}, function (project) {
        console.log("here" + project);
        self.original = project;
        $scope.project = new Project(self.original);
    });

    $scope.isClean = function () {
        return angular.equals(self.original, $scope.project);
    };

    $scope.destroy = function () {
        self.original.destroy(function () {
            $location.path('/list');
        });
    };

    $scope.save = function () {
        $scope.project.update(function () {
            $location.path('/');
        });
    };
}
