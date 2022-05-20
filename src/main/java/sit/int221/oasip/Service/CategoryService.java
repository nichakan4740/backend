package sit.int221.oasip.Service;

import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.server.ResponseStatusException;
import sit.int221.oasip.DTO.CategoryDTO;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Event;
import sit.int221.oasip.Entity.Eventcategory;
import sit.int221.oasip.Repository.EventCategoryRepository;
import sit.int221.oasip.Repository.EventRepository;
import sit.int221.oasip.Utils.ListMapper;

import java.util.List;

@Service
public class CategoryService {
    @Autowired
    private EventCategoryRepository repository;
    @Autowired
    private ModelMapper modelMapper;
    @Autowired
    private ListMapper listMapper;
    //Get all Category
    public List<CategoryDTO> getAllCategory() {
        List<Eventcategory> eventcategories = repository.findAll();
        return listMapper.mapList(eventcategories, CategoryDTO.class , modelMapper);
    }

    //Get category with id
    public CategoryDTO getCategoryById(Integer id) {
        Eventcategory eventcategory = repository.findById(id)
                .orElseThrow(() -> new ResponseStatusException(
                        HttpStatus.NOT_FOUND, "Event id " + id +
                        "Does Not Exist !!!"
                ));
        return modelMapper.map(eventcategory, CategoryDTO.class);
    }

    //update category with id = ?
    public Eventcategory updateId(@RequestBody Eventcategory updateCategory, @PathVariable Integer id) {
        Eventcategory eventcategory = repository.findById(id).map(o->mapCategory(o, updateCategory))
                .orElseGet(()->
                {
                    updateCategory.setId(id);
                    return updateCategory;
                });
        return repository.saveAndFlush(eventcategory);
    }
    private Eventcategory mapCategory(Eventcategory existingEvent, Eventcategory updateEvent) {
        existingEvent.setEventCategoryName(updateEvent.getEventCategoryName());
        existingEvent.setEventCategoryDescription(updateEvent.getEventCategoryDescription());
        existingEvent.setEventDuration(updateEvent.getEventDuration());

        return existingEvent;
    }

}
