<?php

use Prophecy\Argument;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

// https://medium.com/lazy-dev/%E0%B8%9B%E0%B8%B1%E0%B8%8D%E0%B8%AB%E0%B8%B2%E0%B8%99%E0%B9%88%E0%B8%B2%E0%B8%9B%E0%B8%A7%E0%B8%94%E0%B8%AB%E0%B8%B1%E0%B8%A7%E0%B8%82%E0%B8%AD%E0%B8%87-no-access-control-allow-origin-1e3d24932d9b
// เปรียบเสมือนเป็น server ตัวเอง ที่พยายามเรียก server ตัวเอง
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');


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

            $app->post("/member/update/{member_id}", function (Request $request, Response $response) {
                try {
                    $member = new Member();
                    $data = $member->memberUpdate($request);
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

            $app->delete("/member/delete/{member_id}", function (Request $request, Response $response) {
                try {
                    $member = new Member();
                    $data = $member->memberDelete($request);
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
