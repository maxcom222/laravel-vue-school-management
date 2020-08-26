<template>

   <div>
       <li class="list-group-item" :class="className">
            <slot></slot>
           <small class="time">{{ time }}</small>
        </li>
       <small class="badge float-right" :class="badgeColor">{{ user }}</small>
   </div>
</template>

<script>
    export default {
        props: [
            'color',
            'user',
            'time',
        ],
        computed : {
            className() {
                 return 'list-group-item-' + this . color;
            },
            badgeColor() {
                return 'badge-' + this.color;
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style scoped>
    .time {
        margin-top: 10px;
        font-size: 8px;
    }
    </style>