function petHtml(data, species, breed) {
    var len = data.length;
    var str = '';
    for (var i = 0; i < len; i++) {
         str += '<tr>';
            str += '<td>';
                str += '<b><a href="javascript:void(0);" name="m_pid_his" data-ownername="' + $('#p_ownername').text() + '" data-petname="' + data[i].pname + '" data-pid="' + data[i].pid + '" title="health history">' + data[i].pname + '</a></b>';
            str += '</td>';
            str += '<td>';
                str +=  data[i].pbday;
            str += '</td>';
            str += '<td>';
                str += data[i].specdesc;
            str += '</td>';
            str += '<td>';
                str += data[i].breeddesc;
            str += '</td>';
            str += '<td>';
                str += data[i].pgender;
            str += '</td>';
            
            str += '<td>';                    
                str += '<a href="javascript:void(0);" name="m_pet_edit" data-pid="' + data[i].pid + '" data-oid="' + data[i].oid + '" title="Edit"><i class="fa fa-edit"></i></a> ';
                str += '<span> | </span>';
                str += '<a href="javascript:void(0);" name="m_pet_delete" data-pid="' + data[i].pid + '" data-oid="' + data[i].oid + '"  title="Delete" ><i class="fa fa-trash"></i></a>';
            str += '</td>';
        str += '</tr>';
    }
    
    if (len === 0) {
        str = '<tr><td colspan="6" class="text-center">No data available in table</td></tr>'
    }
    $('table #m_pet_tbody_details').html(str);
}

function specHtml(data, specid='') {
    var sel = '';
    var len = data.length;
    var str = '<option value="">Select...</option>';
    for (var i = 0; i < len; i++) {
        sel = data[i].specid === specid ? 'selected' : '';
        str += '<option value="'+data[i].specid+'" '+sel+'>'+data[i].specdesc+'</option>';
    }
    return str;
}

function breedHtml(data, breedid='') {
    var sel = '';
    var len = data.length;
    var str = '<option value="">Select...</option>';
    for (var i = 0; i < len; i++) {
        sel = data[i].breedid === breedid ? 'selected' : '';
        str += '<option value="'+data[i].breedid+'" '+sel+'>'+data[i].breeddesc+'</option>';
    }
    return str;
}


function receiptHtml(data, cash) {
    var tslibdqty_str = '';
    var total_amt = 0;
    var total_oa = 0;

    var str = '';
    str += '<table class="table-receipt">';
        // str += '<thead>';
        //     str += '<tr>';
        //         str += '<th style=""></th>';
        //         str += '<th style="width: 20%;"></th>';
        //     str += '</tr>';
        // str += '</thead>';
        str += '<tbody>';
        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            tslibdqty_str = data[i].tslibdqty + ' X P' + data[i].libdprice + '/Unit';
            total_amt = data[i].tslibdqty * data[i].libdprice;
            total_oa += total_amt;

            str += '<tr>';
                str += '<td style="width: 80%; text-align: left;"><div>' + data[i].libdesc + ' ' + (data[i].libdbarcode == null ? '' : data[i].libdbarcode) + '</div><div>' + (data[i].tslibdqty == '1' ? '' : tslibdqty_str) + '</div></td>'; 
                str += '<td style="width: 20%; text-align: right;">' + total_amt.toFixed(2) + '</td>';
            str += '</tr>';

            if ((data[i].tsdiscount*1) > 0) {
                discount = data[i].tslibdqty * data[i].tsdiscount;

                str += '<tr>';
                    str += '<td style="width: 80%; text-align: left;">Discount/Unit</td>'; 
                    str += '<td style="width: 20%; text-align: right;"> -' + discount.toFixed(2) + '</td>';
                str += '</tr>';

                total_oa -= discount;
            }
        }
        str += '</tbody>';

        str += '<tfoot>';
            str += '<tr>';
                str += '<th colspan="2" style="border-top: 1px solid #eee; padding: 5px;"></th>';
            str += '</tr>';
            str += '<tr>';
                str += '<th style="width: 80%; text-align: right;">TOTAL : </th>';
                str += '<th style="width: 20%; text-align: right;">' + total_oa.toFixed(2) + '</th>';
            str += '</tr>';
            str += '<tr>';
                str += '<th style="width: 80%; text-align: right;">CASH : </th>';
                str += '<th style="width: 20%; text-align: right;">' + cash.toFixed(2) + '</th>';
            str += '</tr>';
            str += '<tr>';
                str += '<th style="width: 80%; text-align: right;">CHANGE : </th>';
                str += '<th style="width: 20%; text-align: right;">' + (cash - total_oa).toFixed(2) + '</th>';
            str += '</tr>';
        str += '</tfoot>';
    str += '</table>';

    return str;       
}


function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}


function stockcardHtml(header_, body_) {
    var str = '';
    var len = header_.length;
    var beg_qty = 0;
    for (var i = 0; i < len; i++) {
        beg_qty = header_[i].libdqty;

        str += '<tr>';
            str += '<td class="text-right">' + beg_qty + '</td>';
            str += '<td></td>';
            str += '<td></td>';
            str += '<td class="text-right">' + beg_qty + '</td>';
            str += '<td></td>';
            str += '<td></td>';
            str += '<td></td>';
        str += '</tr>';
    }

    var issue_qty = 0;
    var rem_qty = beg_qty * 1;

    len = body_.length;
    for (var i = 0; i < len; i++) {
        issue_qty = body_[i].tslibdqty * 1;
        rem_qty -= issue_qty; 
        str += '<tr>';
            str += '<td></td>';
            str += '<td>' + (body_[i].trannumber === null ? '' : body_[i].trannumber) + '</td>';
            str += '<td class="text-right">' + issue_qty + '</td>';
            str += '<td class="text-right">' + rem_qty + '</td>';
            str += '<td class="text-right">' + (body_[i].tsdiscount == '0.00' ? '' : body_[i].tsdiscount) + '</td>';
            str += '<td>' + (body_[i].tsremarks === null ? '' : body_[i].tsremarks) + '</td>';
            str += '<td>';
                if (body_[i].tslocation === 'ADJ') {
                    str += '<a href="javascript:void(0);" name="editadjustqty" data-transservid="' + body_[i].transservid + '"><i class="fa fa-edit"></i> </a>';
                }
            str += '</td>';
        str += '</tr>';
    }

    return str;
}