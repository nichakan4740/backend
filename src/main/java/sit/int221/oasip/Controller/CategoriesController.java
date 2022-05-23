package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import sit.int221.oasip.DTO.CategoriesDTO;
import sit.int221.oasip.Entity.Categories;
import sit.int221.oasip.Service.CategoriesService;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/categories")
class CategoriesController {
    @Autowired
    private CategoriesService service;

    //Get all EventCategory
    @GetMapping("")
    public List<CategoriesDTO> getAllCategory(){
        return service.getAllCategory();
    }

    //Get EventCategory with id
    @GetMapping("/{id}")
    public CategoriesDTO getCustomerById (@PathVariable Integer id) {
        return service.getCategoryById(id);
    }

    //Update an EventCategory with id = ?
    @PutMapping("/{id}")
    public Categories update(@RequestBody Categories updateCategory, @PathVariable Integer id) {
        return service.updateId(updateCategory , id); }

}
