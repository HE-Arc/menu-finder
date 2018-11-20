let makeInputDynamic = ($container) => {
    let $input = $container.find("input");
    let $div = $container.find("div").find("div");
    let $inputClone = $input.clone();
    let $div2 = $div.parent();
    let $addBtn = $container.find(".add-more");
    var $removeBtn = $('<button id="remove" class="btn btn-danger remove-me btn-primary" >-</button></div>');
    let inputCount = 1;

    let onAddBtnClick = e =>{
        inputCount++;
        let $newInput = $inputClone.clone();
        let $newRemoveBtn = $removeBtn.clone();
        let $divId = $div.attr("id");
        let $newDiv = $('<div></div>');
        $newDiv.attr("id", $divId);
        $newInput.data('')

        $addBtn.replaceWith($newRemoveBtn);
        $newDiv.append($newInput);
        $addBtn.appendTo($newDiv);

        $newRemoveBtn.click((e) => {            
            e.preventDefault();
            $newRemoveBtn.parent().remove()
        });

        $div2.append($newDiv);
        $addBtn.one('click', onAddBtnClick);
    };

    $addBtn.one('click', onAddBtnClick);
};

makeInputDynamic($('#starter-container'));
makeInputDynamic($('#dish-container'));
makeInputDynamic($('#dessert-container'));
