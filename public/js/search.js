new Vue({
    http: {
        root: '/root',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
        }
    },
    el: '#vueApp',
    data: {
        persons: 0,
        hoscode: '',
        txtName: '',
        txtLastName: '',
        fullName: {
            'fName': '',
            'lName': ''
        },
        option: 'b',
        hospital: {}
    },
    created() {
        this.$http.get('/alienPerson/api/hospcodes').then((res) =>{
            this.hospital = res.data.hospital
        })
    },
    filters: {
        getPrename(value) {
            switch (value) {
                case '001':
                    this.pName = "ด.ช."
                    break;
                case '002':
                    this.pName = "ด.ญ."
                    break;
                case '003':
                    this.pName = "นาย"
                    break;
                case '004':
                    this.pName = "นางสาว"
                    break;
                case '005':
                    this.pName = "นาง"
                    break;
                default:
                    this.pName = ""
                    break;
            }
            return `${this.pName}`
        },
        getDate(date) {
            const d = new Date(date)
            const m = [
                'มกราคม',
                'กุมภาพันธ์',
                'มีนาคม',
                'เมษายน',
                'พฤษภาคม',
                'มิถุนายน',
                'กรกฎาคม',
                'สิงหาคม',
                'กันยายน',
                'ตุลาคม',
                'พฤศจิกายน',
                'ธันวาคม'
            ]
            const month = m[(d.getMonth())]
            return `${d.getDate() < 10
                ? '0' + d.getDate()
                : d.getDate()} ${month} ${d.getFullYear()+543}`
        }
    },
    methods: {
        getPersonById() {
            console.log(this.hoscode)
            this.$http.post("/alienPerson/api/getPersonById", this.hoscode).then((res) => {
                this.persons = res.data
                console.log(this.persons)
            })
        },
        getPersonByName(txtName) {
            this.fullName.fName = txtName.target.value
            console.log(this.fullName.fName)
            this.$http.post("/alienPerson/api/getPersonByFullName", this.fullName).then((res) => {
                this.persons = res.data
                console.log(this.persons)
            })
        },
        getPersonByLastName(txtLastName) {
            this.fullName.lName = txtLastName.target.value
            console.log(this.fullName.lName)
            this.$http.post("/alienPerson/api/getPersonByFullName", this.fullName).then((res) => {
                this.persons = res.data
                console.log(this.persons)
            })
        },
        deleteRecord(id){
            console.log(id)
            var self = this
            swal({
                title: 'คุณแน่ใจว่าต้องการลบ ?',
                text: "ไม่ต้องการลบกด ยกเลิก !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน !',
                cancelButtonText: 'ยกเลิก',
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                  self.$http.delete("/alienPerson/data/"+id).then((res) => {
                      console.log('Record Delete Successfully')
                      location.href = '/alienPerson/data/search';
                  })
                  swal(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                  );
                    return true;
                } else {
                    return false;
                }
            }.bind(self))
        }
    }
})
