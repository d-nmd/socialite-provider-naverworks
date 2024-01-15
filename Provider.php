<?php

namespace SocialiteProviders\NaverWorks;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'NAVERWORKS';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://auth.worksmobile.com/oauth2/v2.0/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://auth.worksmobile.com/oauth2/v2.0/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://www.worksapis.com/v1.0/users/me',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     *
     * @see https://developers.naver.com/docs/login/profile/
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'        => Arr::get($user, 'response.userId'),
            'name'      => Arr::get($user, 'response.userName'),
            // 'nickname'  => Arr::get($user, 'response.nickname'),
            'email'     => Arr::get($user, 'response.email'),
            'avatar'    => Arr::get($user, 'response.profile_image') ?? null,
        ]);
    }
}
