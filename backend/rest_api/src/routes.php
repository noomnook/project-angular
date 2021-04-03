<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once('../models/member.php');

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->group("/api", function () use ($app) {
        $app->group("/v1", function () use ($app) {
            $app->get("/member", function (Request $request, Response $response) {
                try {
                    $member = new Member();
                    $data = $member->memberList();
                    $response = $response->withHeader("Content-Type", "application/json");
                    $response = $response->withStatus(200, "OK");
                    $response = $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
                    return $response;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                } finally {
                    $member->clearConn();
                }
            });

            $app->get("/member/{member_id}", function (Request $request, Response $response) {
                try {
                    $member = new Member();
                    $data = $member->memberDetail($request);
                    $response = $response->withHeader("Content-Type", "application/json");
                    $response = $response->withStatus(200, "OK");
                    $response = $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
                    return $response;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                } finally {
                    $member->clearConn();
                }
            });

            $app->post("/member/add", function (Request $request, Response $response) {
                try {
                    $member = new Member();
                    $data = $member->memberAdd($request);
                    $response = $response->withHeader("Content-Type", "application/json");
                    $response = $response->withStatus(200, "OK");
                    $response = $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
                    return $response;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                } finally {
                    $member->clearConn();
                }
            });
        });
    });
};
