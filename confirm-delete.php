<?php declare(strict_types=1);
    require_once 'bootstrap.php';

    use App\Registry;
    use App\Helpers\FlashMessage;
    use App\Services\UserRepository;
    use App\Services\TweetRepository;
    use App\Services\PhotoRepository;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $decision = $_POST["decision"];

        if($decision === "delete") {

        }
        $response = new RedirectResponse("index.php");
        $response->send();
    } else {
        $response = new RedirectResponse("index.php");
        $response->send();
    }
