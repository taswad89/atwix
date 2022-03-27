<?php

declare(strict_types=1);

namespace Atwix\Test\Observer\Customer;

class RegisterSuccess implements \Magento\Framework\Event\ObserverInterface
{
    
    protected $_customerRepositoryInterface;

    protected $_logger;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Atwix\Test\Logger\Logger $logger
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_logger = $logger;
    }
    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        // Current Date And Time:
        $date = date('Y-m-d H:i:s');

        //Get Customer Data
        $customer = $observer->getEvent()->getCustomer();
        
        $firstName = $customer->getFirstName();
        // Remove Space in FirstName
        $namewithoutSpace = preg_replace('/\s+/', '', $firstName);
        $customer->setFirstname($namewithoutSpace);
        $this->_customerRepositoryInterface->save($customer);
        
        // $customerID = $customer->getId();
        $email = $customer->getEmail();
        
        $firstName = $customer->getFirstName();
        
        $lastName = $customer->getLastName();

        // Log customer Details 
        $this->_logger->info('Date:'.$date);
        $this->_logger->info('FirsName:'.$firstName);
        $this->_logger->info('LastName:'.$lastName);
        $this->_logger->info('Email:'.$email);
    }
}

