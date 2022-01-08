<template>
     <span :class="class_name">
      {{(date==null)?"":(format || 'Y/m/d')
       .replace('Y',date.getFullYear())
       .replace('y',(date.getFullYear()+"").substr(2))

       .replace('w',date.getDay())
       .replace('m',((date.getMonth()+101)+"").substr(1))
       .replace('d',((date.getDate()+100 )+"").substr(1))

        .replace('h',(((date.getHours()%12) +101)+"").substr(1))
        .replace('H',((date.getHours() +100)+"").substr(1))
        .replace('i',((date.getMinutes()+100)+"").substr(1))
        .replace('s',((date.getSeconds()+100)+"").substr(1))
        .replace('W',((week_days || default_week_days))[date.getDay()])
       }}
     </span>
</template>

<script>
    export default {
        props:['date','format','week_days','class_name'],
        data(){
            return {
                default_week_days:['日','月','火','水','木','金','土']
            }
        },
    }
</script>