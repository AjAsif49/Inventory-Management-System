<template>
    <div class="purple-border form-group">
        <div >
            <h1>Send Email</h1>
            <textarea class="form-control" v-model="notes" cols="30" rows="10"></textarea>
        </div>
        <br>
        <button class="btn btn-sm btn-info" @click="sendmail">Send Mail to  all customer</button>
    </div>
</template>


<script>
export default {
name: 'send_mail',
data() {
    return {
        notes: ''
    }
}, 
methods: {
    sendmail() {
        console.log('calling sendmail');
         axios.post('api/send-mail', {
            'notes': this.notes
         })
        .then((res) => {
          console.log('mail sending...', res);
         Notification.success()
        })
    
    }
}

}
</script>

<style scoped>
.purple-border textarea {
    border: 1px solid #ba68c8;
}
.purple-border .form-control:focus {
    border: 1px solid #ba68c8;
    box-shadow: 0 0 0 0.2rem rgba(186, 104, 200, .25);
}

.green-border-focus .form-control:focus {
    border: 1px solid #8bc34a;
    box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, .25);
}
</style>

