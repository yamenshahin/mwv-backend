import Vue from "vue"

Vue.filter('unCamelCase', function (value) {
    if (!value) return ''
    value = value.toString()
    return value
        // insert a space between lower & upper
        .replace(/([a-z])([A-Z])/g, '$1 $2')
        // space before last upper in a sequence followed by lower
        .replace(/\b([A-Z]+)([A-Z])([a-z])/, '$1 $2$3')
        // uppercase the first character
        .replace(/^./, function (str) {
            return str.toUpperCase();
        })
})

Vue.filter('isoDateToString', function (isoDate) {
    const dateString = new Date(isoDate)
    let hours = ''
    let minutes = ''
    if (dateString.getHours() < 10) {
      hours = '0' + dateString.getHours()
    } else {
      hours = dateString.getHours()
    }
    if (dateString.getMinutes() < 10) {
      minutes = '0' + dateString.getMinutes()
    } else {
      minutes = dateString.getMinutes()
    }
    return (
      dateString.getDate() +
      '/' +
      (dateString.getMonth() + 1) +
      '/' +
      dateString.getFullYear() +
      ' ' +
      hours +
      ':' +
      minutes
    )
})

Vue.filter('percentage', function (amount) {
    return amount + '%'
})

Vue.filter('currency', function (amount) {
    return '£' + amount
})

Vue.filter('vanSize', function (vanSize) {
    if (vanSize === '1') {
        return 'Small Van'
      } else if (vanSize === '2') {
        return 'Medium Van'
      } else if (vanSize === '3') {
        return 'Large Van'
      } else {
        return 'Giant Van'
      }
})

Vue.filter('helpersRequired', function (helpersRequired) {
    if (helpersRequired === '0') {
        return 'No help needed'
      } else if (helpersRequired === '1') {
        return 'Driver helping'
      } else if (helpersRequired === '2') {
        return 'Driver helping + 1 helper'
      } else {
        return ' Driver helping + 2 helpers'
      }
})

Vue.filter('stairs', function (stairs) {
    if (stairs === 0 || stairs === 'null') {
        return 'No flights of stairs'
      } else if (stairs === 1) {
        return '1 flights of stairs'
      } else if (stairs === 2) {
        return '2 flights of stairs'
      } else if (stairs === 3) {
        return '3 flights of stairs'
      } else if (stairs === 4) {
        return '4 flights of stairs'
      } else if (stairs === 5) {
        return '5 flights of stairs'
      } else if (stairs === 6) {
        return '6 flights of stairs'
      } else if (stairs === 7) {
        return '7 flights of stairs'
      } else if (stairs === 8) {
        return '8 flights of stairs'
      } else {
        return 'A lift'
      }
})