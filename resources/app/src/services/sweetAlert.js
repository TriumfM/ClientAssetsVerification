import swal from 'sweetalert2/dist/sweetalert2.js'
export default {

  informationPopUp (title, text, type) {
    swal({
      title: title,
      text: text,
      type: type,
      customClass: 'sweetalert-lg'
    })
  },

  loading: function () {
    swal({
      title: 'Loading!',
      text: '',
      imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
      imageWidth: 50,
      imageHeight: 50,
      imageAlt: 'loading',
      showConfirmButton: false,
      customClass: 'sweetalert-lg'
    })
  },

  deletePopUp: function (action, text) {
    swal({
      title: 'Are you sure?',
      type: 'question',
      text: text,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      closeOnConfirm: false,
      customClass: 'sweetalert-lg'

    })
      .then((result) => {
        if (result.value) {
          action()
          swal({
            title: 'Loading!',
            text: '',
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 50,
            imageHeight: 50,
            imageAlt: 'loading',
            showConfirmButton: false,
            customClass: 'sweetalert-lg'
          })
        } else {
        }
      })
  },

  modifyPopUp: function (action) {
    swal({
      title: 'Are you sure?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      closeOnConfirm: false,
      customClass: 'sweetalert-lg'
    })
      .then((result) => {
        if (result.value) {
          action()
          swal({
            title: 'Loading!',
            text: null,
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 50,
            imageHeight: 50,
            imageAlt: 'loading',
            showConfirmButton: false
          })
        } else {
        }
      })
  },

  addPopUp: function (action) {
    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm',
      closeOnConfirm: false,
      customClass: 'sweetalert-lg'
    })
      .then((result) => {
        if (result.value) {
          action()
          swal({
            title: 'Added!',
            text: 'Row has been added.',
            type: 'success',
            customClass: 'sweetalert-lg'
          })
        } else {
          swal({
            title: 'Loading!',
            text: 'Modal with a custom image.',
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 100,
            imageHeight: 100,
            imageAlt: 'loading'
          })
        }
      })
  },

  removeBuilding: function (action) {
    swal({
      title: 'Are you sure?',
      text: 'You will remove building from access list!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm',
      closeOnConfirm: true,
      customClass: 'sweetalert-lg'

    })
  }
}
