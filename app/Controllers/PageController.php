<?php

namespace App\Controllers;

use ORM;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class PageController
{
    public function index(Request $request, Response $response, $args)
    {
        $renderer = new PhpRenderer('resources');
        $jobs_list = ORM::for_table('jobs')
            ->select('jobs.id')
            ->select('jobs.name')
            ->select('jobs.date')
            ->select('job_types.name','job_type')
            ->select('locations.name','location')
            ->select('firms.src','img')
            ->innerJoin( 'job_types', array('jobs.id_job_types','=','job_types.id'))
            ->innerJoin( 'locations', array('jobs.id_locations','=','locations.id'))
            ->innerJoin( 'firms', array('jobs.id_firm','=','firms.id'))
            ->orderByDesc('jobs.date')
            ->limit(6)
            ->findMany();

        $categories = ORM::for_table('categories')->raw_query('SELECT categories.id, categories.name, COUNT(jobs.id_categories) FROM categories LEFT JOIN jobs ON categories.id = jobs.id_categories GROUP BY categories.id ORDER BY COUNT(jobs.id_categories) DESC LIMIT 8')->findMany();
    //    $jobs_list = ORM::for_table('categories')->raw_query('SELECT jobs.id, jobs.name, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date
        // FROM jobs
        // INNER JOIN job_types ON jobs.id_job_types = job_types.id
        // INNER JOIN locations ON locations.id = jobs.id_locations
        // INNER JOIN firms ON firms.id = jobs.id_firm
        // ORDER BY `jobs`.`date` DESC LIMIT 6')->findMany();

        return $renderer->render($response, "index.php", ['popular_categories' => $categories, 'jobs_list'=>$jobs_list]);
    }

    public function job_details(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        $renderer = new PhpRenderer('resources');
$job = ORM::forTable('jobs')
    ->select('jobs.id')
    ->select('jobs.name','name')
    ->select('jobs.description')
    ->select('locations.name','l_name')
    ->select('job_types.name','types_name')
    ->select('firms.src','img')
    ->select('jobs.date')
    ->select('jobs.Salary')
    ->innerJoin( 'locations', array('jobs.id_locations','=','locations.id'))
    ->innerJoin( 'job_types', array('jobs.id_job_types','=','job_types.id'))
    ->innerJoin( 'firms', array('jobs.id_firm','=','firms.id'))
    ->where('jobs.id',[$id])
    ->findOne();

   //     $job = ORM::for_table('job')->raw_query("
        //SELECT jobs.id, jobs.name as name,jobs.description, locations.name AS l_name, job_types.name as types_name, firms.src, jobs.date, jobs.Salary
        // FROM jobs
        // INNER JOIN job_types ON jobs.id_job_types = job_types.id
        // INNER JOIN locations ON locations.id = jobs.id_locations
        // INNER JOIN firms ON firms.id = jobs.id_firm
        // WHERE jobs.id={$id}")->findOne();

        return $renderer->render($response, "job_details.php", ['job' => $job]);

    }
    public function footer(Request $request, Response $response, $args){
        $categories = ORM::forTable('categories')
            ->select('categories.name')
            ->count('jobs.id_categories')

    }
}