let makeInputDynamic = ($container) => {
    let $input = $container.find("input").last();
    let $div = $container.find("div").find("div");
    let $inputClone = $input.clone();
    let $div2 = $div.parent();
    let $addBtn = $container.find(".add-more").last();
    let $removeButtons = $container.find('.remove-me');
    if($removeButtons.length > 0){
        $removeButtons.each(function () {
            $(this).click((e)=>{
                e.preventDefault();
                $(this).parent().remove();
            });
        });
    }
    let $removeBtn = '<button id="remove" class="btn btn-danger remove-me plusMinusBtn" >-</button></div>';
    let inputCount = 1;

    let onAddBtnClick = e =>{
        inputCount++;
        let $newInput = $inputClone.clone();
        let $newRemoveBtn = $($removeBtn).clone();
        let $divId = $div.attr("id");
        let $newDiv = $('<div></div>');
        $newDiv.attr("id", $divId);
        $newInput.val('');
        $newInput.removeAttr('required');

        $addBtn.replaceWith($newRemoveBtn);
        $newDiv.append($newInput);
        $newDiv.append("\n");
        $addBtn.appendTo($newDiv);

        $newRemoveBtn.click((e) => {            
            e.preventDefault();
            $newRemoveBtn.parent().remove();
        });

        $div2.append($newDiv);
        $addBtn.one('click', onAddBtnClick);
    };

    $addBtn.one('click', onAddBtnClick);
};
$(document).ready(() => {
    $('select.select-picker').selectpicker();
});

makeInputDynamic($('#starter-container'));
makeInputDynamic($('#dish-container'));
makeInputDynamic($('#dessert-container'));
