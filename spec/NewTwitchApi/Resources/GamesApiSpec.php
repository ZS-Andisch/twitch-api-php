<?php

namespace spec\NewTwitchApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class GamesApiSpec extends ObjectBehavior
{
    public function let(Client $guzzleClient)
    {
        $this->beConstructedWith($guzzleClient);
    }

    public function it_should_get_games_by_ids(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?id=12345&id=98765', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGames('TEST_TOKEN', ['12345', '98765'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_games_by_names(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?name=mario&name=sonic', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGames('TEST_TOKEN', [], ['mario', 'sonic'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_games_by_ids_and_names(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games?id=12345&id=98765&name=mario&name=sonic', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getGames('TEST_TOKEN', ['12345', '98765'], ['mario', 'sonic'])->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_top_games(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games/top', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTopGames('TEST_TOKEN')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_top_games_with_first(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games/top?first=100', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTopGames('TEST_TOKEN', 100)->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_top_games_with_before(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games/top?before=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTopGames('TEST_TOKEN', null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_should_get_top_games_with_after(Client $guzzleClient, Response $response)
    {
        $guzzleClient->send(new Request('GET', 'games/top?after=abc', ['Authorization' => 'Bearer TEST_TOKEN']))->willReturn($response);
        $this->getTopGames('TEST_TOKEN', null, null, 'abc')->shouldBeAnInstanceOf(ResponseInterface::class);
    }
}
