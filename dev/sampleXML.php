<?php
$sampleResult = '<GetSellerTransactionsResponse xmlns="urn:ebay:apis:eBLBaseComponents">
  <Timestamp>2018-10-30T20:12:03.907Z</Timestamp>
  <Ack>Success</Ack>
  <Version>1083</Version>
  <Build>E1083_CORE_APIXO_18856776_R1</Build>
  <PaginationResult>
    <TotalNumberOfPages>1</TotalNumberOfPages>
    <TotalNumberOfEntries>2</TotalNumberOfEntries>
  </PaginationResult>
  <HasMoreTransactions>false</HasMoreTransactions>
  <TransactionsPerPage>100</TransactionsPerPage>
  <PageNumber>1</PageNumber>
  <ReturnedTransactionCountActual>2</ReturnedTransactionCountActual>
  <Seller>
    <AboutMePage>false</AboutMePage>
    <EIASToken>n==</EIASToken>
    <Email>magicalbookseller@yahoo.com</Email>
    <FeedbackScore>2</FeedbackScore>
    <PositiveFeedbackPercent>75.0</PositiveFeedbackPercent>
    <FeedbackPrivate>false</FeedbackPrivate>
    <FeedbackRatingStar>None</FeedbackRatingStar>
    <IDVerified>true</IDVerified>
    <eBayGoodStanding>true</eBayGoodStanding>
    <NewUser>false</NewUser>
    <RegistrationDate>2004-05-27T00:00:00.000Z</RegistrationDate>
    <Site>US</Site>
    <Status>Confirmed</Status>
    <UserID>magicalbookseller</UserID>
    <UserIDChanged>false</UserIDChanged>
    <UserIDLastChanged>2007-11-29T18:43:54.000Z</UserIDLastChanged>
    <VATStatus>NoVATTax</VATStatus>
    <SellerInfo>
      <AllowPaymentEdit>true</AllowPaymentEdit>
      <CheckoutEnabled>true</CheckoutEnabled>
      <CIPBankAccountStored>false</CIPBankAccountStored>
      <GoodStanding>true</GoodStanding>
      <QualifiesForB2BVAT>false</QualifiesForB2BVAT>
      <StoreOwner>true</StoreOwner>
      <StoreURL>http://www.stores.sandbox.ebay.com/id=132854966</StoreURL>
      <SafePaymentExempt>true</SafePaymentExempt>
    </SellerInfo>
  </Seller>
  <TransactionArray>
    <Transaction>
      <AmountPaid currencyID="USD">22.5</AmountPaid>
      <AdjustmentAmount currencyID="USD">0.0</AdjustmentAmount>
      <ConvertedAdjustmentAmount currencyID="USD">0.0</ConvertedAdjustmentAmount>
      <Buyer>
        <AboutMePage>false</AboutMePage>
        <EIASToken>nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoDZKDpQqdj6x9nY+seQ==</EIASToken>
        <Email>Invalid Request</Email>
        <FeedbackScore>1</FeedbackScore>
        <PositiveFeedbackPercent>100.0</PositiveFeedbackPercent>
        <FeedbackPrivate>false</FeedbackPrivate>
        <FeedbackRatingStar>None</FeedbackRatingStar>
        <IDVerified>false</IDVerified>
        <eBayGoodStanding>true</eBayGoodStanding>
        <NewUser>false</NewUser>
        <RegistrationDate>1995-01-01T00:00:00.000Z</RegistrationDate>
        <Site>US</Site>
        <Status>Confirmed</Status>
        <UserID>bigbuyer</UserID>
        <UserIDChanged>false</UserIDChanged>
        <UserIDLastChanged>2009-02-12T05:01:49.000Z</UserIDLastChanged>
        <VATStatus>NoVATTax</VATStatus>
        <BuyerInfo>
          <ShippingAddress>
            <Name>Big Buyer</Name>
            <Street1>208 Woods Street</Street1>
            <CityName>Hana</CityName>
            <StateOrProvince>HA</StateOrProvince>
            <Country>US</Country>
            <CountryName>United States</CountryName>
            <Phone>(808) 123-2344</Phone>
            <PostalCode>96713</PostalCode>
            <AddressID>4744883</AddressID>
            <AddressOwner>eBay</AddressOwner>
          </ShippingAddress>
        </BuyerInfo>
        <UserAnonymized>false</UserAnonymized>
      </Buyer>
      <ShippingDetails>
        <ChangePaymentInstructions>true</ChangePaymentInstructions>
        <PaymentEdited>false</PaymentEdited>
        <SalesTax>
          <SalesTaxPercent>8.25</SalesTaxPercent>
          <SalesTaxState>CA</SalesTaxState>
          <ShippingIncludedInTax>true</ShippingIncludedInTax>
          <SalesTaxAmount currencyID="USD">0.0</SalesTaxAmount>
        </SalesTax>
        <ShippingType>Flat</ShippingType>
        <SellingManagerSalesRecordNumber>144</SellingManagerSalesRecordNumber>
        <TaxTable>
          <TaxJurisdiction>
            <JurisdictionID>CA</JurisdictionID>
            <SalesTaxPercent>8.25</SalesTaxPercent>
            <ShippingIncludedInTax>true</ShippingIncludedInTax>
          </TaxJurisdiction>
        </TaxTable>
      </ShippingDetails>
      <ConvertedAmountPaid currencyID="USD">22.5</ConvertedAmountPaid>
      <ConvertedTransactionPrice currencyID="USD">20.0</ConvertedTransactionPrice>
      <CreatedDate>2018-10-27T19:40:31.000Z</CreatedDate>
      <DepositType>None</DepositType>
      <Item>
        <AutoPay>false</AutoPay>
        <Currency>USD</Currency>
        <ItemID>110043277865</ItemID>
        <ListingType>Chinese</ListingType>
        <PaymentMethods>PayPal</PaymentMethods>
        <PrivateListing>false</PrivateListing>
        <Quantity>1</Quantity>
        <SellingStatus>
          <BidCount>1</BidCount>
          <CurrentPrice currencyID="USD">20.0</CurrentPrice>
          <QuantitySold>1</QuantitySold>
          <ListingStatus>Completed</ListingStatus>
        </SellingStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Item>
      <QuantityPurchased>1</QuantityPurchased>
      <Status>
        <eBayPaymentStatus>NoPaymentFailure</eBayPaymentStatus>
        <CheckoutStatus>SellerResponded</CheckoutStatus>
        <LastTimeModified>2018-10-27T20:41:59.000Z</LastTimeModified>
        <PaymentMethodUsed>None</PaymentMethodUsed>
        <CompleteStatus>Incomplete</CompleteStatus>
        <BuyerSelectedShipping>false</BuyerSelectedShipping>
        <PaymentHoldStatus>None</PaymentHoldStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Status>
      <TransactionID>0</TransactionID>
      <TransactionPrice currencyID="USD">20.0</TransactionPrice>
      <BestOfferSale>false</BestOfferSale>
      <ShippingServiceSelected>
        <ShippingService>USPSMedia</ShippingService>
        <ShippingServiceCost currencyID="USD">2.5</ShippingServiceCost>
      </ShippingServiceSelected>
      <TransactionSiteID>US</TransactionSiteID>
      <Platform>eBay</Platform>
      <IntangibleItem>false</IntangibleItem>
    </Transaction>
    <Transaction>
      <AmountPaid currencyID="USD">3.5</AmountPaid>
      <AdjustmentAmount currencyID="USD">0.0</AdjustmentAmount>
      <ConvertedAdjustmentAmount currencyID="USD">0.0</ConvertedAdjustmentAmount>
      <Buyer>
        <AboutMePage>false</AboutMePage>
        <EIASToken>n==</EIASToken>
        <Email>bountifulbuyer@gmail.com</Email>
        <FeedbackScore>1</FeedbackScore>
        <PositiveFeedbackPercent>100.0</PositiveFeedbackPercent>
        <FeedbackPrivate>false</FeedbackPrivate>
        <FeedbackRatingStar>None</FeedbackRatingStar>
        <IDVerified>false</IDVerified>
        <eBayGoodStanding>true</eBayGoodStanding>
        <NewUser>false</NewUser>
        <RegistrationDate>1995-01-01T00:00:00.000Z</RegistrationDate>
        <Site>US</Site>
        <Status>Confirmed</Status>
        <UserID>bountifulbuyer</UserID>
        <UserIDChanged>false</UserIDChanged>
        <UserIDLastChanged>2009-02-12T05:01:49.000Z</UserIDLastChanged>
        <VATStatus>NoVATTax</VATStatus>
        <BuyerInfo>
          <ShippingAddress>
            <Name>Bountiful Buyer</Name>
            <Street1>123 Gharky Lane</Street1>
            <CityName>Walla Walla</CityName>
            <StateOrProvince>WA</StateOrProvince>
            <Country>US</Country>
            <CountryName>United States</CountryName>
            <Phone>(408) 123-2344</Phone>
            <PostalCode>99362</PostalCode>
            <AddressID>5244731</AddressID>
            <AddressOwner>eBay</AddressOwner>
          </ShippingAddress>
        </BuyerInfo>
        <UserAnonymized>false</UserAnonymized>
      </Buyer>
      <ShippingDetails>
        <ChangePaymentInstructions>true</ChangePaymentInstructions>
        <PaymentEdited>false</PaymentEdited>
        <SalesTax>
          <SalesTaxPercent>0.0</SalesTaxPercent>
          <ShippingIncludedInTax>false</ShippingIncludedInTax>
          <SalesTaxAmount currencyID="USD">0.0</SalesTaxAmount>
        </SalesTax>
        <ShippingType>Flat</ShippingType>
        <SellingManagerSalesRecordNumber>149</SellingManagerSalesRecordNumber>
      </ShippingDetails>
      <ConvertedAmountPaid currencyID="USD">3.5</ConvertedAmountPaid>
      <ConvertedTransactionPrice currencyID="USD">1.0</ConvertedTransactionPrice>
      <CreatedDate>2018-10-17T17:32:40.000Z</CreatedDate>
      <Item>
        <AutoPay>false</AutoPay>
        <Currency>USD</Currency>
        <ItemID>110043671232</ItemID>
        <ListingType>Chinese</ListingType>
        <PaymentMethods>PayPal</PaymentMethods>
        <PrivateListing>false</PrivateListing>
        <Quantity>1</Quantity>
        <SellingStatus>
          <BidCount>1</BidCount>
          <CurrentPrice currencyID="USD">1.0</CurrentPrice>
          <QuantitySold>1</QuantitySold>
          <ListingStatus>Completed</ListingStatus>
        </SellingStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Item>
      <QuantityPurchased>4</QuantityPurchased>
      <Status>
        <eBayPaymentStatus>NoPaymentFailure</eBayPaymentStatus>
        <CheckoutStatus>CheckoutComplete</CheckoutStatus>
        <LastTimeModified>2018-10-17T17:32:40.000Z</LastTimeModified>
        <PaymentMethodUsed>PayPal</PaymentMethodUsed>
        <CompleteStatus>Complete</CompleteStatus>
        <BuyerSelectedShipping>false</BuyerSelectedShipping>
        <PaymentHoldStatus>None</PaymentHoldStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Status>
      <TransactionID>1</TransactionID>
      <TransactionPrice currencyID="USD">1.0</TransactionPrice>
      <BestOfferSale>false</BestOfferSale>
      <ShippingServiceSelected>
        <ShippingService>USPSMedia</ShippingService>
        <ShippingServiceCost currencyID="USD">2.5</ShippingServiceCost>
      </ShippingServiceSelected>
      <TransactionSiteID>US</TransactionSiteID>
      <Platform>eBay</Platform>
      <IntangibleItem>false</IntangibleItem>
    </Transaction>
    <Transaction>
      <AmountPaid currencyID="USD">3.5</AmountPaid>
      <AdjustmentAmount currencyID="USD">0.0</AdjustmentAmount>
      <ConvertedAdjustmentAmount currencyID="USD">0.0</ConvertedAdjustmentAmount>
      <Buyer>
        <AboutMePage>false</AboutMePage>
        <EIASToken>n==</EIASToken>
        <Email>bountifulbuyer@gmail.com</Email>
        <FeedbackScore>1</FeedbackScore>
        <PositiveFeedbackPercent>100.0</PositiveFeedbackPercent>
        <FeedbackPrivate>false</FeedbackPrivate>
        <FeedbackRatingStar>None</FeedbackRatingStar>
        <IDVerified>false</IDVerified>
        <eBayGoodStanding>true</eBayGoodStanding>
        <NewUser>false</NewUser>
        <RegistrationDate>1995-01-01T00:00:00.000Z</RegistrationDate>
        <Site>US</Site>
        <Status>Confirmed</Status>
        <UserID>bountifulbuyer</UserID>
        <UserIDChanged>false</UserIDChanged>
        <UserIDLastChanged>2009-02-12T05:01:49.000Z</UserIDLastChanged>
        <VATStatus>NoVATTax</VATStatus>
        <BuyerInfo>
          <ShippingAddress>
            <Name>Bountiful Buyer</Name>
            <Street1>123 Gharky Lane</Street1>
            <CityName>Walla Walla</CityName>
            <StateOrProvince>WA</StateOrProvince>
            <Country>US</Country>
            <CountryName>United States</CountryName>
            <Phone>(408) 123-2344</Phone>
            <PostalCode>99362</PostalCode>
            <AddressID>5244731</AddressID>
            <AddressOwner>eBay</AddressOwner>
          </ShippingAddress>
        </BuyerInfo>
        <UserAnonymized>false</UserAnonymized>
      </Buyer>
      <ShippingDetails>
        <ChangePaymentInstructions>true</ChangePaymentInstructions>
        <PaymentEdited>false</PaymentEdited>
        <SalesTax>
          <SalesTaxPercent>0.0</SalesTaxPercent>
          <ShippingIncludedInTax>false</ShippingIncludedInTax>
          <SalesTaxAmount currencyID="USD">0.0</SalesTaxAmount>
        </SalesTax>
        <ShippingType>Flat</ShippingType>
        <SellingManagerSalesRecordNumber>149</SellingManagerSalesRecordNumber>
      </ShippingDetails>
      <ConvertedAmountPaid currencyID="USD">3.5</ConvertedAmountPaid>
      <ConvertedTransactionPrice currencyID="USD">1.0</ConvertedTransactionPrice>
      <CreatedDate>2018-10-17T17:32:40.000Z</CreatedDate>
      <Item>
        <AutoPay>false</AutoPay>
        <Currency>USD</Currency>
        <ItemID>110043671232</ItemID>
        <ListingType>Chinese</ListingType>
        <PaymentMethods>PayPal</PaymentMethods>
        <PrivateListing>false</PrivateListing>
        <Quantity>1</Quantity>
        <SellingStatus>
          <BidCount>1</BidCount>
          <CurrentPrice currencyID="USD">1.0</CurrentPrice>
          <QuantitySold>1</QuantitySold>
          <ListingStatus>Completed</ListingStatus>
        </SellingStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Item>
      <QuantityPurchased>1</QuantityPurchased>
      <Status>
        <eBayPaymentStatus>NoPaymentFailure</eBayPaymentStatus>
        <CheckoutStatus>CheckoutComplete</CheckoutStatus>
        <LastTimeModified>2018-10-17T17:32:40.000Z</LastTimeModified>
        <PaymentMethodUsed>PayPal</PaymentMethodUsed>
        <CompleteStatus>Complete</CompleteStatus>
        <BuyerSelectedShipping>false</BuyerSelectedShipping>
        <PaymentHoldStatus>None</PaymentHoldStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Status>
      <TransactionID>2</TransactionID>
      <TransactionPrice currencyID="USD">1.0</TransactionPrice>
      <BestOfferSale>false</BestOfferSale>
      <ShippingServiceSelected>
        <ShippingService>USPSMedia</ShippingService>
        <ShippingServiceCost currencyID="USD">2.5</ShippingServiceCost>
      </ShippingServiceSelected>
      <TransactionSiteID>US</TransactionSiteID>
      <Platform>eBay</Platform>
      <IntangibleItem>false</IntangibleItem>
    </Transaction>
    <Transaction>
      <AmountPaid currencyID="USD">3.5</AmountPaid>
      <AdjustmentAmount currencyID="USD">0.0</AdjustmentAmount>
      <ConvertedAdjustmentAmount currencyID="USD">0.0</ConvertedAdjustmentAmount>
      <Buyer>
        <AboutMePage>false</AboutMePage>
        <EIASToken>n==</EIASToken>
        <Email>bountifulbuyer@gmail.com</Email>
        <FeedbackScore>1</FeedbackScore>
        <PositiveFeedbackPercent>100.0</PositiveFeedbackPercent>
        <FeedbackPrivate>false</FeedbackPrivate>
        <FeedbackRatingStar>None</FeedbackRatingStar>
        <IDVerified>false</IDVerified>
        <eBayGoodStanding>true</eBayGoodStanding>
        <NewUser>false</NewUser>
        <RegistrationDate>1995-01-01T00:00:00.000Z</RegistrationDate>
        <Site>US</Site>
        <Status>Confirmed</Status>
        <UserID>bountifulbuyer</UserID>
        <UserIDChanged>false</UserIDChanged>
        <UserIDLastChanged>2009-02-12T05:01:49.000Z</UserIDLastChanged>
        <VATStatus>NoVATTax</VATStatus>
        <BuyerInfo>
          <ShippingAddress>
            <Name>Bountiful Buyer</Name>
            <Street1>123 Gharky Lane</Street1>
            <CityName>Walla Walla</CityName>
            <StateOrProvince>WA</StateOrProvince>
            <Country>US</Country>
            <CountryName>United States</CountryName>
            <Phone>(408) 123-2344</Phone>
            <PostalCode>99362</PostalCode>
            <AddressID>5244731</AddressID>
            <AddressOwner>eBay</AddressOwner>
          </ShippingAddress>
        </BuyerInfo>
        <UserAnonymized>false</UserAnonymized>
      </Buyer>
      <ShippingDetails>
        <ChangePaymentInstructions>true</ChangePaymentInstructions>
        <PaymentEdited>false</PaymentEdited>
        <SalesTax>
          <SalesTaxPercent>0.0</SalesTaxPercent>
          <ShippingIncludedInTax>false</ShippingIncludedInTax>
          <SalesTaxAmount currencyID="USD">0.0</SalesTaxAmount>
        </SalesTax>
        <ShippingType>Flat</ShippingType>
        <SellingManagerSalesRecordNumber>149</SellingManagerSalesRecordNumber>
      </ShippingDetails>
      <ConvertedAmountPaid currencyID="USD">3.5</ConvertedAmountPaid>
      <ConvertedTransactionPrice currencyID="USD">1.0</ConvertedTransactionPrice>
      <CreatedDate>2018-10-17T17:32:40.000Z</CreatedDate>
      <Item>
        <AutoPay>false</AutoPay>
        <Currency>USD</Currency>
        <ItemID>110043671232</ItemID>
        <ListingType>Chinese</ListingType>
        <PaymentMethods>PayPal</PaymentMethods>
        <PrivateListing>false</PrivateListing>
        <Quantity>1</Quantity>
        <SellingStatus>
          <BidCount>1</BidCount>
          <CurrentPrice currencyID="USD">1.0</CurrentPrice>
          <QuantitySold>1</QuantitySold>
          <ListingStatus>Completed</ListingStatus>
        </SellingStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Item>
      <QuantityPurchased>1</QuantityPurchased>
      <Status>
        <eBayPaymentStatus>NoPaymentFailure</eBayPaymentStatus>
        <CheckoutStatus>CheckoutComplete</CheckoutStatus>
        <LastTimeModified>2018-10-17T17:32:40.000Z</LastTimeModified>
        <PaymentMethodUsed>PayPal</PaymentMethodUsed>
        <CompleteStatus>Complete</CompleteStatus>
        <BuyerSelectedShipping>false</BuyerSelectedShipping>
        <PaymentHoldStatus>None</PaymentHoldStatus>
        <IntegratedMerchantCreditCardEnabled>false</IntegratedMerchantCreditCardEnabled>
      </Status>
      <TransactionID>0</TransactionID>
      <TransactionPrice currencyID="USD">1.0</TransactionPrice>
      <BestOfferSale>false</BestOfferSale>
      <ShippingServiceSelected>
        <ShippingService>USPSMedia</ShippingService>
        <ShippingServiceCost currencyID="USD">2.5</ShippingServiceCost>
      </ShippingServiceSelected>
      <TransactionSiteID>US</TransactionSiteID>
      <Platform>eBay</Platform>
      <IntangibleItem>false</IntangibleItem>
    </Transaction>
  </TransactionArray>
  <PayPalPreferred>true</PayPalPreferred>
</GetSellerTransactionsResponse>';
?>
