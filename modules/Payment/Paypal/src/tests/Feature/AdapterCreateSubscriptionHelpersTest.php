<?php

namespace Srmklive\PayPal\Tests\Feature;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srmklive\PayPal\Tests\MockClientClasses;
use Srmklive\PayPal\Tests\MockResponsePayloads;

class AdapterCreateSubscriptionHelpersTest extends TestCase
{
    use MockClientClasses;
    use MockResponsePayloads;

    /** @var string */
    protected static $access_token = '';

    /** @var \Srmklive\PayPal\Services\PayPal */
    protected $client;

    protected function setUp(): void
    {
        $this->client = new PayPalClient($this->getApiCredentials());

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockAccessTokenResponse()
            )
        );
        $response = $this->client->getAccessToken();

        self::$access_token = $response['access_token'];

        parent::setUp();
    }

    /** @test */
    public function it_can_create_a_monthly_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addPlanTrialPricing('DAY', 7)
            ->addMonthlyPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setReturnAndCancelUrl('https://example.com/paypal-success', 'https://example.com/paypal-cancel')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_create_a_daily_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addPlanTrialPricing('DAY', 7)
            ->addDailyPlan('Demo Plan', 'Demo Plan', 1.50);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setReturnAndCancelUrl('https://example.com/paypal-success', 'https://example.com/paypal-cancel')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_create_a_weekly_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addPlanTrialPricing('DAY', 7)
            ->addWeeklyPlan('Demo Plan', 'Demo Plan', 50);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setReturnAndCancelUrl('https://example.com/paypal-success', 'https://example.com/paypal-cancel')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_create_an_annual_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addPlanTrialPricing('DAY', 7)
            ->addAnnualPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setReturnAndCancelUrl('https://example.com/paypal-success', 'https://example.com/paypal-cancel')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_create_a_subscription_with_custom_defined_interval()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addPlanTrialPricing('DAY', 7)
            ->addCustomPlan('Demo Plan', 'Demo Plan', 100, 'MONTH', 3);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setReturnAndCancelUrl('https://example.com/paypal-success', 'https://example.com/paypal-cancel')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_throws_exception_when_invalid_interval_is_provided_for_creating_a_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434');

        $this->expectException(\RuntimeException::class);

        $this->client = $this->client->addCustomPlan('Demo Plan', 'Demo Plan', 100, 'MONTHLY', 3);
    }

    /** @test */
    public function it_can_create_a_subscription_without_trial()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateCatalogProductsResponse()
            )
        );

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreatePlansResponse()
            )
        );

        $this->client = $this->client->addMonthlyPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_create_a_subscription_by_existing_product_and_billing_plan()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_skips_product_and_billing_plan_creation_if_already_set_when_creating_a_daily_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE')
            ->addDailyPlan('Demo Plan', 'Demo Plan', 1.50);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_skips_product_and_billing_plan_creation_if_already_set_when_creating_a_weekly_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE')
            ->addWeeklyPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_skips_product_and_billing_plan_creation_if_already_set_when_creating_a_monthly_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE')
            ->addMonthlyPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_skips_product_and_billing_plan_creation_if_already_set_when_creating_an_annual_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE')
            ->addAnnualPlan('Demo Plan', 'Demo Plan', 100);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_skips_product_and_billing_plan_creation_if_already_set_when_creating_a_subscription_with_custom_intervals()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ')
            ->addProduct('Demo Product', 'Demo Product', 'SERVICE', 'SOFTWARE')
            ->addCustomPlan('Demo Plan', 'Demo Plan', 100, 'MONTH', 3);

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_add_setup_fees_when_creating_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();
        $setup_fee = 9.99;

        $this->client = $this->client->addSetupFee($setup_fee)
            ->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_add_shipping_address_when_creating_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();

        $this->client = $this->client->addShippingAddress('John Doe', 'House no. 123', 'Street 456', 'Test Area', 'Test Area', 10001, 'US')
            ->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }

    /** @test */
    public function it_can_add_custom_payment_failure_threshold_value_when_creating_subscription()
    {
        $this->client->setAccessToken([
            'access_token' => self::$access_token,
            'token_type' => 'Bearer',
        ]);

        $start_date = Carbon::now()->addDay()->toDateString();
        $threshold = 5;

        $this->client = $this->client->addPaymentFailureThreshold($threshold)
            ->addProductById('PROD-XYAB12ABSB7868434')
            ->addBillingPlanById('P-5ML4271244454362WXNWU5NQ');

        $this->client->setClient(
            $this->mock_http_client(
                $this->mockCreateSubscriptionResponse()
            )
        );

        $response = $this->client->setupSubscription('John Doe', 'john@example.com', $start_date);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('plan_id', $response);
    }
}
