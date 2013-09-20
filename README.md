aelodaeth
=========

A membership library for CodeIgniter.

This library was originally developed for http://clwbrygbicaernarfon.co.uk, i.e. Clwb Rygbi Caernarfon Rugby Club's website. 

### Dependencies

The HTML was based on Bootstrap and used the Metis administration theme. 

GoCardless is used as a payment processor and needs their PHP library. 

CKEditor is used for rich text editing. 

### Development Notes

When I first developed this, records were written straight to the DB. No permanent accounts were made. 

When I recently rewrote it, I made the password field unique, and would update a record if the email address matched. 

It soon became apparent that this was a problem as some members did not have their own email, and would borrow their wives'/partners' address. Or parent would use their own when paying for their offspring. 

Presently not a huge problem, but I hope to sort this for next season. 

### ToDo

* Password & security
* Proper documentation
* Reduce the HTML to a minimum
* Move more variables to config
* Test! It's had plenty of testing within the original project, but this hasn't had any (yet)

### Club specific functions

* International Ticket application form
* Club events payment form
