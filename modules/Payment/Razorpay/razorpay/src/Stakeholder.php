<?php

namespace Razorpay\Api;

class Stakeholder extends Entity
{
    public function create($attributes = [])
    {
        $url = 'accounts/'.$this->account_id.'/'.$this->getEntityUrl();

        return $this->request('POST', $url, $attributes, 'v2');
    }

    public function fetch($id)
    {
        $entityUrl = 'accounts/'.$this->account_id.'/'.$this->getEntityUrl().'/'.$id;

        return $this->request('GET', $entityUrl, null, 'v2');
    }

    public function all($options = [])
    {
        $relativeUrl = 'accounts/'.$this->account_id.'/'.$this->getEntityUrl();

        return $this->request('GET', $relativeUrl, $options, 'v2');
    }

    public function edit($id, $attributes = [])
    {
        $entityUrl = 'accounts/'.$this->account_id.'/'.$this->getEntityUrl().'/'.$id;

        return $this->request('PATCH', $entityUrl, $attributes, 'v2');
    }
}
