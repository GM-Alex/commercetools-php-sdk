<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\Core\Channel;


use Commercetools\Core\ApiTestCase;
use Commercetools\Core\Model\Channel\Channel;
use Commercetools\Core\Model\Channel\ChannelDraft;
use Commercetools\Core\Request\Channels\ChannelCreateRequest;
use Commercetools\Core\Request\Channels\ChannelDeleteRequest;

class ChannelCreateRequestTest extends ApiTestCase
{
    /**
     * @return ChannelDraft
     */
    protected function getDraft()
    {
        $draft = ChannelDraft::ofKey(
            'test-' . $this->getTestRun() . '-key'
        );

        return $draft;
    }

    protected function createChannel(ChannelDraft $draft)
    {
        /**
         * @var Channel $channel
         */
        $response = $this->getClient()
            ->execute(ChannelCreateRequest::ofDraft($draft));

        $channel = $response->toObject();

        $this->cleanupRequests[] = ChannelDeleteRequest::ofIdAndVersion(
            $channel->getId(),
            $channel->getVersion()
        );

        return $channel;
    }


    public function testCreate()
    {
        $draft = $this->getDraft();
        $channel = $this->createChannel($draft);
        $this->assertSame($draft->getKey(), $channel->getKey());
    }
}
