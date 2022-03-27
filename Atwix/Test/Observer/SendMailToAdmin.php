<?php
namespace Atwix\Test\Observer;

use Magento\Framework\Event\ObserverInterface;

class SendMailToAdmin implements ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
    protected $_transportBuilder;
    protected $_inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    protected $_escaper;
    protected $_logLoggerInterface;

    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->_logLoggerInterface = $loggerInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $email = $customer->getEmail();
        $firstName = $customer->getFirstName();
        $lastName = $customer->getLastName();

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        try
        {
            $this->_inlineTranslation->suspend(); 
            $sentToEmail = self::XML_PATH_EMAIL_RECIPIENT_EMAIL;
            
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('customerinfo_email_template')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ]
                )
                ->setTemplateVars([
                    'name'      => $firstName,
                    'lastname'  => $lastName,
                    'email'     => $email
                ])
                ->setFrom('general')
                ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT_EMAIL, $storeScope))
                ->getTransport();
                 
                $transport->sendMessage();
                 
                $this->_inlineTranslation->resume();
                 
        } catch(\Exception $e){
            $this->_logLoggerInterface->debug($e->getMessage());
		}

    }

}