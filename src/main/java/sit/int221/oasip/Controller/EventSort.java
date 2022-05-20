package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
        import org.springframework.data.domain.Sort;
        import org.springframework.http.HttpStatus;
        import org.springframework.validation.annotation.Validated;
        import org.springframework.web.bind.annotation.*;
        import org.springframework.web.server.ResponseStatusException;
        import sit.int221.oasip.DTO.EventDTO;
        import sit.int221.oasip.Entity.Event;
        import sit.int221.oasip.Repository.EventRepository;
        import sit.int221.oasip.Service.EventService;
import sit.int221.oasip.Service.SortService;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/sort")
class EventSort  {
    @Autowired
    private SortService service;

    @Autowired
    private EventRepository repository;

    //Get all Event
    @GetMapping("")
    public List<EventDTO> getSort(@RequestParam(defaultValue = "eventStartTime") String sortBy){
        return service.getSort(sortBy);
    }

    }