<script>
function toggle(el) { 
if (el.style.display == 'none'){ 
el.filters.blendTrans.Apply(); 
el.style.display = ''; 
el.filters.blendTrans.Play() 
} 
else { 
el.filters.blendTrans.Apply(); 
el.style.display = 'none'; 
el.filters.blendTrans.Play() 
} 
}
</script>
