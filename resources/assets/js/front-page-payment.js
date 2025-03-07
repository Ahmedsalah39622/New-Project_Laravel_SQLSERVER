document.addEventListener('DOMContentLoaded', function() {
    const paymentButton = document.getElementById('proceedPaymentBtn');

    if (paymentButton) {
        paymentButton.addEventListener('click', function() {
            const appointmentId = this.dataset.appointmentId;

            fetch('/appointment/update-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    appointment_id: appointmentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert('Payment successful! Appointment status updated to paid.');
                    window.location.href = '/home';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Payment failed. Please try again.');
            });
        });
    }
});
'use strict';

(function () {
  // Variables
  const billingZipCode = document.querySelector('.billings-zip-code'),
    creditCardMask = document.querySelector('.billing-card-mask'),
    expiryDateMask = document.querySelector('.billing-expiry-date-mask'),
    cvvMask = document.querySelector('.billing-cvv-mask'),
    formCheckInputPayment = document.querySelectorAll('.form-check-input-payment'),
    payNowButton = document.getElementById('pay-now');

  // Pincode Mask
  if (billingZipCode) {
    new Cleave(billingZipCode, {
      delimiter: '',
      numeral: true
    });
  }

  // Credit Card Mask
  if (creditCardMask) {
    new Cleave(creditCardMask, {
      creditCard: true,
      onCreditCardTypeChanged: function (type) {
        const cardTypeContainer = document.querySelector('.card-type');
        if (type !== '' && type !== 'unknown') {
          cardTypeContainer.innerHTML = `<img src="${assetsPath}img/icons/payments/${type}-cc.png" height="28"/>`;
        } else {
          cardTypeContainer.innerHTML = '';
        }
      }
    });
  }

  // Expiry Date Mask
  if (expiryDateMask) {
    new Cleave(expiryDateMask, {
      date: true,
      delimiter: '/',
      datePattern: ['m', 'y']
    });
  }

  // CVV Mask
  if (cvvMask) {
    new Cleave(cvvMask, {
      numeral: true,
      numeralPositiveOnly: true
    });
  }

  // Toggle Credit Card Form based on Payment Method Selection
  if (formCheckInputPayment) {
    formCheckInputPayment.forEach(function (paymentInput) {
      paymentInput.addEventListener('change', function (e) {
        const paymentInputValue = e.target.value;
        document.querySelector('#form-credit-card').classList.toggle('d-none', paymentInputValue !== 'credit-card');
      });
    });
  }

  // Function to Process Payment
  function processPayment(appointmentId) {

    fetch('/appointment/update-payment', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ appointment_id: appointmentId })
    })
      .then(response => response.json())
      .then(data => {
        if (data.message) {
          alert('Payment successful! Appointment status updated to paid.');
          window.location.href = '/home';
        } else {
          alert('Payment failed. Please try again.');
        }
      })
      .catch(error => console.error('Error:', error));
  }

  // Event Listener for "Proceed with Payment" Button
  if (payNowButton) {
    payNowButton.addEventListener('click', function () {
      let appointmentId = this.getAttribute('data-appointment-id');
      console.log("Appointment ID:", appointmentId);
      processPayment(appointmentId);
    });
  }
})();
